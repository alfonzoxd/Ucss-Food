<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\DolibarrService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, DolibarrService $dolibarr): RedirectResponse
    {
        // 1. Validación actualizada para Nombres y Apellidos separados
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            // Mantenemos tu validación de dominio UCSS
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class, 'ends_with:ucss.pe'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.ends_with' => 'Solo se permiten correos institucionales (@ucss.pe)',
        ]);

        // 2. Creamos el usuario en Laravel con los campos separados
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        // 3. Lógica de Negocio para Dolibarr
        // Concatenamos para crear el Tercero correctamente en el ERP
        $fullNameForDolibarr = $request->first_name . ' ' . $request->last_name;

        try {
            // Enviamos el nombre completo concatenado a la API
            $dolibarr->createThirdParty($fullNameForDolibarr, $request->email);
        } catch (\Exception $e) {
            // Opcional: Loguear el error pero no detener el registro si Dolibarr falla temporalmente
            // \Log::error("Error creando tercero en Dolibarr: " . $e->getMessage());
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirigir al menú principal
        return redirect(route('menu.index', absolute: false));
    }
}
