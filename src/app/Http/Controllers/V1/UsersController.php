<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{

    // Index
    public function index()
    {
        //Listamos todos los comercios
        return User::get();
    }

    // Mostrar usuario
    public function show($id)
    {
        //Bucamos el usuario
        $user = User::find($id);
        // Si el usuario no existe devolvemos error no encontrado
        if (!$user) {
            return response()->json([
                'message' => 'Uusario no encontrado.'
            ], 404);
        }
        // Si hay existe el usuario lo devolvemos
        return $user;
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        // Validacion de datos
        $data = $request->only('identification', 'names', 'last_names', 'state', 'password', 'date_c', 'profile_id');
        $validator = Validator::make($data, [
            'identification' => 'required|string|min:9|max:9',
            'names'          => 'required|string',
            'last_names'     => 'required|string',
            'state'          => 'required|string',
            // 'password'       => 'string|min:6|max:50',
            'date_c'         => 'required',
            'profile_id'     => 'required',
        ]);
        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        // Buscamos el usuario
        $user = User::findOrfail($id);
        if ($request->password == "") {
            $password = $user->password;
        }else {
            $password = bcrypt($request->password);
        }
        // Creando el new user
        $user->update([
            'identification' =>        $request->identification,
            'names'          =>        $request->names,
            'last_names'     =>        $request->last_names,
            'state'          =>        $request->state,
            'password'       =>        $password,
            'date_c'         =>        $request->date_c,
            'profile_id'     =>        $request->profile_id
        ]);

        // Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Usuario actualizado con éxito!',
            'data' => $user
        ], Response::HTTP_OK);
    }

    // Eliminamos el usuario
    public function destroy($id)
    {
        // Usamos carbon para obtener la fecha
        $now = Carbon::now();

        // Buscamos el usuario
        $user = User::findOrfail($id);

        // Eliminamos el usuario "aparentemente"
        $user->update([
            'deleted_at' => $now,
        ]);
        // $user->delete();

        // Devolvemos la respuesta
        return response()->json([
            'message' => 'Usuario eliminado con éxito!'
        ], Response::HTTP_OK);
    }
}
