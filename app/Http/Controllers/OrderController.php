<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DolibarrService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $dolibarr;

    public function __construct(DolibarrService $dolibarr)
    {
        $this->dolibarr = $dolibarr;
    }

    // En App\Http\Controllers\OrderController.php

public function index()
{
    $user = Auth::user();
    $history = new Collection();
    $socid = $this->dolibarr->findThirdPartyByEmail($user->email);

    if ($socid) {
        // 1. Traer Facturas
        $invoices = $this->dolibarr->getInvoicesByThirdParty($socid);

        // 2. Traer Pedidos
        $orders = $this->dolibarr->getOrdersByThirdParty($socid);

        // PROCESAR FACTURAS
        foreach ($invoices as $inv) {
            // Estado 0 = Borrador (Pendiente), 1 o 2 = Validada/Pagada (Aprobado)
            $statusInv = (int)$inv['statut'];
            $isApproved = $statusInv > 0;

            // Determinamos el archivo para descargar (last_main_doc suele tener la ruta)
            $documento = $inv['last_main_doc'] ?? null;

            $history->push([
                'type'   => 'invoice',
                'id'     => $inv['id'], // Necesario si quieres descargar por ID
                'ref'    => $inv['ref'],
                // Dolibarr a veces devuelve 'date' y a veces 'datec'
                'date'   => $inv['date'] ?? $inv['datec'] ?? time(),
                'amount' => $inv['total_ttc'],
                'status' => $isApproved ? ($statusInv == 2 ? 'Pagada' : 'Validada') : 'Borrador',
                'color'  => $isApproved ? 'green' : 'yellow',
                'file'   => $documento // Guardamos la referencia para la vista
            ]);
        }

        // PROCESAR PEDIDOS (Solo los no facturados)
        foreach ($orders as $ord) {
            $isBilled = isset($ord['billed']) && (int)$ord['billed'] === 1;

            if (!$isBilled) {
                $status = (int)$ord['statut'];
                // Mapeo de estados de pedido
                $statusText = match ($status) {
                    0 => 'Borrador',
                    1 => 'Validado',
                    2 => 'Enviado',
                    3 => 'Entregado',
                    -1 => 'Cancelado',
                    default => 'Pendiente'
                };

                $history->push([
                    'type'   => 'order',
                    'id'     => $ord['id'],
                    'ref'    => $ord['ref'],
                    'date'   => $ord['date_commande'] ?? time(),
                    'amount' => $ord['total_ttc'],
                    'status' => $statusText,
                    'color'  => ($status >= 1) ? 'yellow' : 'red', // Pedidos suelen ser pendientes hasta ser factura
                    'file'   => null
                ]);
            }
        }
    }

    $history = $history->sortByDesc('date')->values();
    return view('orders.index', ['orders' => $history]);
}



// ... dentro de tu clase OrderController ...

public function downloadInvoice(Request $request, $ref)
{
    // 1. Definir la ruta BASE donde Dolibarr guarda todo.
    // Según tu captura de pantalla es esta:
    $basePath = "C:/dolibarr/dolibarr_documents/";

    // 2. Obtener la ruta relativa desde la base de datos (que pasamos desde la vista)
    // Ejemplo de valor en DB: "facture/TC1-2511-0009/TC1-2511-0009.pdf"
    $relativePath = $request->query('path');

    // 3. Construir la ruta completa
    if ($relativePath) {
        $fullPath = $basePath . $relativePath;
    } else {
        // FALLBACK: Si por alguna razón la DB no trajo el dato, lo construimos manualmente
        // usando la referencia, asumiendo la estructura estándar de Dolibarr.
        $fullPath = $basePath . "facture/" . $ref . "/" . $ref . ".pdf";
    }

    // 4. Normalizar las barras (Windows usa \, pero PHP entiende /)
    $fullPath = str_replace('\\', '/', $fullPath);

    Log::info('Intentando abrir archivo local:', ['ruta' => $fullPath]);

    // 5. Verificar si existe y devolverlo
    if (file_exists($fullPath)) {
        return response()->file($fullPath);
    }

    // ERROR: Si no existe, probamos una ruta alternativa común en Windows
    // A veces Dolibarr guarda en C:/xampp... según tu otro ejemplo
    $alternatePath = "C:/xampp/htdocs/dolibarr-22.0.2/documents/facture/$ref/$ref.pdf";

    if (file_exists($alternatePath)) {
        return response()->file($alternatePath);
    }

    // Si no se encuentra en ningún lado, regresamos error
    Log::error('Archivo físico no encontrado: ' . $fullPath);
    return back()->with('error', 'El archivo PDF no se encuentra en el servidor.');
}
}
