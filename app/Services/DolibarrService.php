<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DolibarrService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('DOLIBARR_API_URL');
        $this->apiKey = env('DOLIBARR_API_KEY');
    }

    // En App\Services\DolibarrService.php

public function getProduct($id)
{
    try {
        $response = Http::withHeaders([
            'DOLAPIKEY' => $this->apiKey,
            'Accept'    => 'application/json',
        ])->get($this->baseUrl . '/products/' . $id);

        if ($response->successful()) {
            return $response->json();
        }
    } catch (\Exception $e) {
        Log::error('Error obteniendo producto ' . $id . ': ' . $e->getMessage());
    }
    return null;
}
    public function getProductsByCategory($categoryId)
    {
        $sqlFilter = "(t.rowid:IN:SELECT fk_product FROM llx_categorie_product WHERE fk_categorie=" . $categoryId . ")";

        $params = [
            'sortfield'  => 't.label',
            'sortorder'  => 'ASC',
            'limit'      => 100,
            'sqlfilters' => $sqlFilter
        ];

        try {
            $response = Http::withHeaders([
                'DOLAPIKEY' => $this->apiKey,
                'Accept'    => 'application/json',
            ])->get($this->baseUrl . '/products', $params);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            return [];
        }

        return [];
    }

    public function createThirdParty($name, $email)
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'client' => '1',
            'code_client' => 'auto',
        ];

        try {
            $response = Http::withHeaders([
                'DOLAPIKEY' => $this->apiKey,
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/thirdparties', $data);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
        }

        return null;
    }

    public function getLocalImage($ref)
    {
        $baseDir = 'C:/dolibarr/dolibarr_documents/produit/';

        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $folders = glob($baseDir . $ref . '*', GLOB_ONLYDIR);

        if ($folders !== false && count($folders) > 0) {
            $folder = $folders[0];

            $files = array_diff(scandir($folder), ['.', '..', 'thumbs']);

            foreach ($files as $file) {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (in_array($ext, $imageExtensions)) {
                    $fullPath = $folder . '/' . $file;
                    return [
                        'path' => $fullPath,
                        'mime' => mime_content_type($fullPath)
                    ];
                }
            }
        }

        return null;
    }

    public function createOrder($socid, $lines)
    {
        // Estructura para Dolibarr
        $data = [
            'socid' => (int)$socid,
            'date' => time(),
            'type' => 0, // 0 = Pedido estándar
            'lines' => $lines, // Array de productos
            'note_public' => 'Pedido generado desde Web UCSS FOOD',
        ];

        Log::info('=== CREANDO PEDIDO EN DOLIBARR ===');
        Log::info('Socid: ' . $socid);
        Log::info('Número de líneas: ' . count($lines));
        Log::info('Datos completos a enviar:', [
            'json' => json_encode($data, JSON_PRETTY_PRINT)
        ]);

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'DOLAPIKEY' => $this->apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/orders', $data);

            Log::info('=== RESPUESTA DE DOLIBARR ===');
            Log::info('Status HTTP: ' . $response->status());
            Log::info('Body completo: ' . $response->body());

            if ($response->successful()) {
                $result = $response->json();
                Log::info('Pedido creado exitosamente', ['result' => $result]);

                // Extraer el ID del pedido
                if (is_numeric($result)) {
                    return $result;
                } elseif (is_array($result) && isset($result['id'])) {
                    return $result['id'];
                } elseif (is_string($result) && is_numeric($result)) {
                    return $result;
                }

                return $result;
            } else {
                // Log detallado del error
                Log::error('=== ERROR EN CREACIÓN DE PEDIDO ===');
                Log::error('Status: ' . $response->status());
                Log::error('Body: ' . $response->body());

                $errorData = $response->json();
                if (isset($errorData['error'])) {
                    Log::error('Error específico: ' . json_encode($errorData['error']));
                }
            }

        } catch (\Exception $e) {
            Log::error('=== EXCEPCIÓN AL CREAR PEDIDO ===');
            Log::error('Mensaje: ' . $e->getMessage());
            Log::error('Archivo: ' . $e->getFile() . ' línea ' . $e->getLine());
        }

        return null;
    }

    public function validateOrder($orderId, $warehouseId = 1)
    {
        $data = [
            'idwarehouse' => $warehouseId
        ];

        try {
            $response = Http::withHeaders([
                'DOLAPIKEY' => $this->apiKey,
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/orders/' . $orderId . '/validate', $data);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findThirdPartyByEmail($email)
    {
        $sqlFilter = "(t.email:like:'" . $email . "')";

        $params = [
            'sqlfilters' => $sqlFilter,
            'limit' => 1
        ];

        try {
            $response = Http::withHeaders([
                'DOLAPIKEY' => $this->apiKey,
                'Accept'    => 'application/json',
            ])->get($this->baseUrl . '/thirdparties', $params);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && count($data) > 0) {
                    return $data[0]['id'];
                }
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * 1. OBTENER PEDIDOS (Esto ya te funcionaba, lo dejamos igual pero protegido)
     */
    public function getOrdersByThirdParty($socid)
    {
        if (!$socid) return [];

        // Para pedidos, 'thirdparty_ids' suele funcionar bien
        $params = [
            'sortfield'      => 't.date_commande',
            'sortorder'      => 'DESC',
            'limit'          => 100,
            'thirdparty_ids' => $socid
        ];

        try {
            $response = Http::withHeaders([
                'DOLAPIKEY' => $this->apiKey,
                'Accept'    => 'application/json',
            ])->get($this->baseUrl . '/orders', $params);

            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            Log::error('Error buscando pedidos: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * 2. OBTENER FACTURAS (Aquí está el arreglo CRITICO)
     * Dolibarr NO devuelve facturas con 'thirdparty_ids', OBLIGATORIAMENTE requiere 'sqlfilters'
     */
    public function getInvoicesByThirdParty($socid)
    {
        if (!$socid) return [];

        // Sintaxis estricta para el filtro SQL de Dolibarr
        $sqlFilter = "(t.fk_soc:=:" . $socid . ")";

        $params = [
            'sortfield'  => 't.datec',
            'sortorder'  => 'DESC',
            'limit'      => 100,
            'sqlfilters' => $sqlFilter // <--- ESTO ES LA CLAVE
        ];

        try {
            $response = Http::withHeaders([
                'DOLAPIKEY' => $this->apiKey,
                'Accept'    => 'application/json',
            ])->get($this->baseUrl . '/invoices', $params);

            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            Log::error('Error buscando facturas: ' . $e->getMessage());
            return [];
        }
    }
    public function downloadDocument($documentPath)
{
    // El documentPath viene en formato: facture/TC1-2511-0001/TC1-2511-0001.pdf
    // Necesitamos extraer el modulepart y el filename

    $parts = explode('/', $documentPath);
    $modulepart = $parts[0]; // 'facture'
    $filename = implode('/', array_slice($parts, 1)); // 'TC1-2511-0001/TC1-2511-0001.pdf'

    Log::info('Intentando descargar documento:', [
        'path' => $documentPath,
        'modulepart' => $modulepart,
        'filename' => $filename
    ]);

    try {
        $response = Http::withHeaders([
            'DOLAPIKEY' => $this->apiKey,
            'Accept'    => 'application/pdf',
        ])->get($this->baseUrl . '/documents/download', [
            'modulepart' => $modulepart,
            'original_file' => $filename
        ]);

        if ($response->successful()) {
            Log::info('Documento descargado exitosamente');
            return $response->body();
        }

        Log::error('Error en respuesta de Dolibarr:', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        throw new \Exception('No se pudo descargar el documento: ' . $response->status());

    } catch (\Exception $e) {
        Log::error('Dolibarr download document error:', [
            'path' => $documentPath,
            'modulepart' => $modulepart,
            'filename' => $filename,
            'error' => $e->getMessage()
        ]);
        throw $e;
    }
}
}
