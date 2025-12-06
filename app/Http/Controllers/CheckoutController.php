<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\DolibarrService;

class CheckoutController extends Controller
{
    protected $dolibarr;

    public function __construct(DolibarrService $dolibarr)
    {
        $this->dolibarr = $dolibarr;
    }

    public function index()
    {
        return view('checkout.index');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
        ]);

        try {
            $user = Auth::user();

            Log::info('Iniciando proceso de pago', [
                'user_email' => $user->email,
                'cart_items' => count($request->cart)
            ]);

            // PASO 1: Buscar o crear el tercero (cliente) en Dolibarr
            $thirdPartyId = $this->dolibarr->findThirdPartyByEmail($user->email);

            Log::info('Búsqueda de tercero', [
                'email' => $user->email,
                'found_id' => $thirdPartyId
            ]);

            if (!$thirdPartyId) {
                Log::info('Cliente no encontrado, creando nuevo tercero...');

                $customerResponse = $this->dolibarr->createThirdParty($user->name, $user->email);

                Log::info('Respuesta de creación de tercero', [
                    'response' => $customerResponse
                ]);

                // Extraer el ID según el tipo de respuesta
                if (is_numeric($customerResponse)) {
                    $thirdPartyId = (int)$customerResponse;
                } elseif (is_array($customerResponse) && isset($customerResponse['id'])) {
                    $thirdPartyId = (int)$customerResponse['id'];
                } elseif (is_string($customerResponse) && is_numeric($customerResponse)) {
                    $thirdPartyId = (int)$customerResponse;
                }

                Log::info('ID extraído del tercero', ['thirdPartyId' => $thirdPartyId]);
            }

            // Validar que tenemos un ID válido
            if (!$thirdPartyId || $thirdPartyId <= 0) {
                Log::error('No se pudo obtener un ID válido de tercero', [
                    'thirdPartyId' => $thirdPartyId,
                    'user_email' => $user->email
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo registrar el cliente en el sistema ERP. Por favor, contacta con soporte.'
                ], 500);
            }

            // PASO 2: Preparar las líneas del pedido
            $lines = [];
            foreach ($request->cart as $item) {
                if (!isset($item['id']) || !isset($item['qty']) || !isset($item['price'])) {
                    Log::error('Item del carrito incompleto', ['item' => $item]);
                    continue;
                }

                // Verificar si es un menú del día (tiene productIds)
                if (isset($item['productIds']) && is_array($item['productIds'])) {
                    // Es un menú del día, agregar cada producto individualmente
                    Log::info('Procesando menú del día', [
                        'productIds' => $item['productIds'],
                        'label' => $item['label']
                    ]);

                    $pricePerItem = (float)$item['price'] / count($item['productIds']);

                    foreach ($item['productIds'] as $productId) {
                        $lines[] = [
                            'fk_product'   => (int)$productId,
                            'qty'          => (float)$item['qty'],
                            'subprice'     => round($pricePerItem, 2),
                            'tva_tx'       => 0,
                            'product_type' => 0,
                            'desc'         => isset($item['label']) ? $item['label'] : ''
                        ];
                    }
                } else {
                    // Es un producto individual normal
                    // Validar que el ID sea numérico
                    $productId = $item['id'];

                    // Si el ID es string (como "menu_X_Y_Z"), extraer el primer número válido
                    if (is_string($productId) && strpos($productId, 'menu_') === 0) {
                        Log::warning('ID de menú sin productIds array', ['item' => $item]);
                        continue; // Saltar este item
                    }

                    // Asegurar que sea un número entero válido
                    $productId = (int)$productId;

                    if ($productId <= 0) {
                        Log::error('ID de producto inválido', ['item' => $item]);
                        continue;
                    }

                    $lines[] = [
                        'fk_product'   => $productId,
                        'qty'          => (float)$item['qty'],
                        'subprice'     => (float)$item['price'],
                        'tva_tx'       => 0,
                        'product_type' => 0,
                        'desc'         => isset($item['label']) ? $item['label'] : ''
                    ];
                }
            }

            if (empty($lines)) {
                Log::error('No se pudieron procesar las líneas del pedido');
                return response()->json([
                    'success' => false,
                    'message' => 'El carrito no contiene productos válidos.'
                ], 400);
            }

            Log::info('Líneas del pedido preparadas', [
                'total_lines' => count($lines),
                'lines' => json_encode($lines, JSON_PRETTY_PRINT)
            ]);

            // PASO 3: Crear el pedido en Dolibarr
            $orderResponse = $this->dolibarr->createOrder($thirdPartyId, $lines);

            Log::info('Respuesta de creación de pedido', [
                'response' => $orderResponse
            ]);

            // Extraer el ID del pedido
            $orderId = null;
            if (is_numeric($orderResponse)) {
                $orderId = (int)$orderResponse;
            } elseif (is_array($orderResponse) && isset($orderResponse['id'])) {
                $orderId = (int)$orderResponse['id'];
            } elseif (is_string($orderResponse) && is_numeric($orderResponse)) {
                $orderId = (int)$orderResponse;
            }

            if (!$orderId) {
                Log::error('Fallo al crear el pedido en Dolibarr', [
                    'thirdPartyId' => $thirdPartyId,
                    'orderResponse' => $orderResponse
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el pedido en Dolibarr. Revisa los logs del servidor.'
                ], 500);
            }

            // PASO 4: Validar el pedido (opcional, según tu flujo)
            Log::info('Intentando validar pedido', ['orderId' => $orderId]);

            $validated = $this->dolibarr->validateOrder($orderId);

            if (!$validated) {
                Log::warning('No se pudo validar el pedido automáticamente', [
                    'orderId' => $orderId
                ]);
                // No retornamos error aquí, el pedido fue creado exitosamente
            }

            Log::info('Pedido procesado exitosamente', [
                'orderId' => $orderId,
                'validated' => $validated
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pedido #' . $orderId . ' confirmado correctamente.',
                'order_id' => $orderId
            ]);

        } catch (\Exception $e) {
            Log::error('Error crítico en el checkout', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    
}
