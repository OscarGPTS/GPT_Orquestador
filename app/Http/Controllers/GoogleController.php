<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Redirige al usuario a Google para autenticarse
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    /**
     * Maneja la respuesta de Google después de la autenticación
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->user();

            // Buscar o crear el usuario
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt('password'), // Contraseña dummy para OAuth
                ]);
            } else {
                // Actualizar google_id si no existe
                $updates = [];

                if (!$user->google_id) {
                    $updates['google_id'] = $googleUser->getId();
                }

                if (!$user->avatar && $googleUser->getAvatar()) {
                    $updates['avatar'] = $googleUser->getAvatar();
                }

                if (!empty($updates)) {
                    $user->update($updates);
                }
            }

            // Autenticar al usuario
            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            // Log para diagnosticar errores de OAuth (state inválido, credenciales, etc.)
            logger()->error('Google OAuth error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->with('error', 'Error en la autenticación con Google');
        }
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
    }
}
