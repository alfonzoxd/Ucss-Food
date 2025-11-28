<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DolibarrService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('DOLIBARR_API_URL');
        $this->apiKey = env('DOLIBARR_API_KEY');
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
            'socid' => $socid,
            'date' => time(),
            'type' => 0, // 0 = Pedido estándar
            'lines' => $lines, // Array de productos
            'note_public' => 'Pedido generado desde Web UCSS FOOD',
        ];

        try {
            $response = Http::withHeaders([
                'DOLAPIKEY' => $this->apiKey,
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/orders', $data);

            if ($response->successful()) {
                return $response->json(); // Devuelve el ID del pedido (string o int)
            }

            // Para debuggear si falla
            // \Log::error('Error creando pedido Dolibarr: ' . $response->body());
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * Validar el pedido para que descuente Stock
     */
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

}
