<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use JWTAuth;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\ProfilesHasPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProfilesController extends Controller
{
    protected $user;
    public function __construct(Request $request){
        $token = $request->header('Authorization');
        if($token != '')
        //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo almacenamos en una variable, nosotros no lo utilizaremos.
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index() {
        // Listamos todos los perfiles
        return Profile::get();
    }

    public function store(Request $request){
        // Obtenemos los datos
        $data = $request->only('name','description', 'per_id');
        // Validamos los datos
        $validator = Validator::make($data, [
            'name'          => 'required|max:50|string',  // Profile
            'description'   => 'required|max:150|string', // Profile
            'per_id'        => 'required'                 // Permission
        ]);
        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        // Creamos el perfil en la BD
        $profile = Profile::create([
            'name'          => $request->name,
            'description'   => $request->description,
        ]);
        // Obtenemos el ultimo id insertado en la tabla de perfiles
        $last_id = Profile::latest('id')->first();
        $profile_id = $last_id->id;
        // Comprobamos si los permisos son un array
        if (is_array($request->per_id)){
            // Hacemos el recorrido del array e insertamos en la DB
            foreach ($request->per_id as $permission){
                $permissions = ProfilesHasPermission::create([
                    'profile_id'      => $profile_id,
                    'permission_id'   => $permission
                ]);
            }
        // En caso de que no
        }else {
            // Insertamos en la DB
            $permissions = ProfilesHasPermission::create([
                'profile_id'      => $profile_id,
                'permission_id'   => $request->per_id
            ]);
        }

        // Respuesta en caso de que todo vaya bien
        return response()->json([
            'message' => 'Perfil Creado con Éxito',
            'data_in_profile'    => $profile,
            'data_in_permission' => $permissions,
        ],Response::HTTP_OK);
    }

    public function show($id){
        // Buscamos el perfil y los permisos asociados
        $profile = DB::table('profiles_has_permissions as php')
                    ->join('permissions', 'php.permission_id', '=', 'permissions.id')
                    ->join('profiles', 'php.profile_id', '=', 'profiles.id')
                    ->select('profiles.name as profile_name', 'permissions.name as permission_name')
                    ->where('php.profile_id','=',$id)
                    ->get();
        // Si no existe devolvemos error no encontrado
        if(!$profile){
            return response()->json([
                'message' => 'Perfil no encontrado'
            ],400);
        }
        // Si existe el perfil lo devolvemos
        return $profile;
    }

    public function update(Request $request, $id){
        // Validacion de datos
        $data = $request->only('name','description', 'per_id');
        // Validamos los datos
        $validator = Validator::make($data, [
            'name'          => 'required|max:50|string',  // Profile
            'description'   => 'required|max:150|string', // Profile
            'per_id'        => 'required'                 // Permission
        ]);
        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        // Buscamos el perfil
        $profile = Profile::findOrfail($id);
        $profile_id = $profile->id;
        // Actualizamos el perfil
        $profile->update([
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        // Actualizamos los permisos
            // Eliminamos primero los registros de los permisos en la tabla puente
            $delPermissions=ProfilesHasPermission::where('profile_id',$id)->delete();

            // Comprobamos si los permisos son un array
            if (is_array($request->per_id)){
                // Hacemos el recorrido del array e insertamos en la DB
                foreach ($request->per_id as $permission){
                    $permissions = ProfilesHasPermission::create([
                        'profile_id'      => $profile_id,
                        'permission_id'   => $permission
                    ]);
                }
            // En caso de que no
            }else {
                // Insertamos en la DB
                $permissions = ProfilesHasPermission::create([
                    'profile_id'      => $profile_id,
                    'permission_id'   => $request->per_id
                ]);
            }

        // Respuesta en caso de que todo vaya bien
        return response()->json([
            'message' => 'Perfil actualizado con éxito',
            'data_in_profile'    => $profile,
            'data_in_permission' => $permissions,
        ],Response::HTTP_OK);

    }

    public function destroy($id){
        // Usamos carbon para obtener la fecha
        $now = Carbon::now();

        // Buscamos el perfil
        $profile = Profile::findOrfail($id);
        // Eliminamos el perfil "aparentemente"
        $profile->update([
            'deleted_at'=>$now,
        ]);

        // Devolvemos la respuesta
        return response()->json([
            'message' => 'Perfil eliminado con éxito!'
        ], Response::HTTP_OK);
    }
}
