<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // Registrar usuario
    public function register(Request $request)
    {

        // Setear valor para date_c
        $assign_date_c = Carbon::now();
        $date_c = $assign_date_c->format("Y-m-d H:m:s");

        // Datos que se reciben del request
        $data = $request->only('identification', 'names', 'last_names', 'email', 'state', 'password', 'profile_id');

        // Validaciones
        $validator = Validator::make($data, [
            'identification' => 'required|string|min:9|max:9',
            'names'          => 'required|string',
            'last_names'     => 'required|string',
            'email'          => 'required|email|unique:users',
            'state'          => 'required|string',
            'password'       => 'required|string|min:6|max:50',
            'profile_id'     => 'required',
        ]);
        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        // Creando el new user
        $user = User::create([
            'identification' =>        $request->identification,
            'names'          =>        $request->names,
            'last_names'     =>        $request->last_names,
            'email'          =>        $request->email,
            'state'          =>        $request->state,
            'password'       => bcrypt($request->password),
            'date_c'         =>        $date_c,
            'profile_id'     =>        $request->profile_id
        ]);

        // Guardamos user y pass para realizar la petición de token a JWTAuth
        $credentials = $request->only('email', 'password');

        // Devolvemos la respuesta con el token del usuario
        return response()->json([
            'message' => 'Usuario Creado con Éxito',
            'token' => JWTAuth::attempt($credentials),
            'user' => $user
        ], Response::HTTP_OK);
    }

    // Para iniciar sesion
    public function authenticate(Request $request)
    {
        // Obtenemos email y pass del request
        $credentials = $request->only('email', 'password');

        // Validaciones
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        // Intentamos iniciar sesion
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                // Credenciales incorrectas.
                return response()->json([
                    'message' => 'Login failed',
                ], 401);
            }
        } catch (JWTException $e) {
            // Error
            return response()->json([
                'message' => 'Error',
            ], 500);
        }
        // Devolvemos el token
        return response()->json([
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    // Eliminar el token y desconectar al user
    public function logout(Request $request)
    {
        // Validamos que se nos envie el token
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        try {
            // Si el token es valido eliminamos el token desconectando al usuario.
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User disconnected'
            ]);
        } catch (JWTException $exception) {
            // Error
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Obtener el usuario y validar si el token a expirado
    public function getUser(Request $request)
    {
        // Validamos que la request tenga el token
        $this->validate($request, [
            'token' => 'required'
        ]);

        // Realizamos la autentificación
        $user = JWTAuth::authenticate($request->token);

        // Si no hay usuario es que el token no es valido o que ha expirado
        if (!$user)
            return response()->json([
                'message' => 'Token Inválido / Token Expirado',
            ], 401);
        // Devolvemos los datos del usuario si todo va bien.
        return response()->json(['user' => $user]);
    }
}
