<?php

namespace App\Http\Controllers;

use App\Services\DolibarrService;
use Illuminate\View\View;
use Carbon\Carbon;

class MenuController extends Controller
{
    protected $dolibarr;

    public function __construct(DolibarrService $dolibarr)
    {
        $this->dolibarr = $dolibarr;
    }

    public function index(): View
    {
        $diaSemana = Carbon::now()->timezone('America/Lima')->dayOfWeekIso;

        $idEntrada = 9; $idSegundo = 10; $idEjecutivo = 26;

        switch ($diaSemana) {
            case 1: $idEntrada = 9; $idSegundo = 10; $idEjecutivo = 26; break;
            case 2: $idEntrada = 12; $idSegundo = 13; $idEjecutivo = 27; break;
            case 3: $idEntrada = 15; $idSegundo = 16; $idEjecutivo = 28; break;
            case 4: $idEntrada = 18; $idSegundo = 19; $idEjecutivo = 29; break;
            case 5: $idEntrada = 20; $idSegundo = 21; $idEjecutivo = 30; break;
            case 6: $idEntrada = 22; $idSegundo = 23; $idEjecutivo = 31; break;
            default: $idEntrada = 9; $idSegundo = 10; $idEjecutivo = 26; break;
        }

        $idRefrescosMenu = 37;
        // Obtener productos de la API
        $entradas   = $this->dolibarr->getProductsByCategory($idEntrada);
        $fondos     = $this->dolibarr->getProductsByCategory($idSegundo);
        $ejecutivos = $this->dolibarr->getProductsByCategory($idEjecutivo);
        $refrescos  = $this->dolibarr->getProductsByCategory($idRefrescosMenu);
        $bebidas    = $this->dolibarr->getProductsByCategory(24);
        $postres    = $this->dolibarr->getProductsByCategory(25);

        return view('menu.index', compact('entradas', 'fondos','refrescos', 'ejecutivos', 'bebidas', 'postres'));
    }

    public function image($ref)
    {
        $imgData = $this->dolibarr->getLocalImage($ref);

        if ($imgData && file_exists($imgData['path'])) {
            return response()->file($imgData['path']);
        }

        return redirect("https://placehold.co/600x400/e2e8f0/475569?text=Sin+Foto");
    }
}
