<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Importante para debug
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

            // A) Primero intentamos BUSCAR si ya existe
            $thirdPartyId = $this->dolibarr->findThirdPartyByEmail($user->email);

            // B) Si no existe ($thirdPartyId es null), lo CREAMOS
            if (!$thirdPartyId) {
                $customerResponse = $this->dolibarr->createThirdParty($user->name, $user->email);

                // Verificamos si la respuesta es el ID directo o un array
                if (is_numeric($customerResponse)) {
                    $thirdPartyId = $customerResponse;
                } elseif (is_array($customerResponse) && isset($customerResponse['id'])) {
                    $thirdPartyId = $customerResponse['id'];
                }
            }

            // C) Si aún así no tenemos ID (falló creación), usamos un ID Genérico (Asegúrate de tener el cliente ID 1 en Dolibarr)
            if (!$thirdPartyId) {
                // Logueamos el error para que sepas qué pasó
                Log::error('Fallo al crear cliente en Dolibarr para: ' . $user->email);
                // Retornamos error al frontend
                return response()->json(['success' => false, 'message' => 'No se pudo registrar el cliente en el sistema ERP.'], 500);
            }

            $lines = [];
            foreach ($request->cart as $item) {
                $lines[] = [
                    'fk_product' => $item['id'],
                    'qty'       => $item['qty'],
                    'subprice'  => $item['price'],
                    'tva_tx'    => 0,
                    'desc'      => $item['label']
                ];
            }

            $orderId = $this->dolibarr->createOrder($thirdPartyId, $lines);

            if ($orderId) {
                $this->dolibarr->validateOrder($orderId);

                return response()->json(['success' => true, 'message' => 'Pedido #' . $orderId . ' confirmado correctamente.']);
            } else {
                Log::error('Fallo al crear el pedido en Dolibarr. Cliente ID: ' . $thirdPartyId);
                return response()->json(['success' => false, 'message' => 'Error al crear el pedido en Dolibarr.'], 500);
            }

        } catch (\Exception $e) {
            // Esto capturará el error 500 y te dirá qué pasó realmente
            Log::error('Error Crítico Checkout: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error del Servidor: ' . $e->getMessage()], 500);
        }
    }
}
