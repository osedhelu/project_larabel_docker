<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use JWTAuth;
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Commerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CommercesController extends Controller
{
    protected $user;

    // Devolver todos los comercios (Ciertas condiciones aplican)
    public function index()
    {
        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Obtiene todos los registros si el campo deleted_at es null
            $commerce = Commerce::whereNull('deleted_at')
                                    // Filtrandolos por el user_id que coincida con el del usuario autenticado
                                    ->where(function($query) {
                                        $authUser = auth()->user();
                                        $query->where('user_id','=',$authUser->id);
                                    })
                                    ->get();
            // Si no hay resultados, devolvemos 404
            if (!$commerce) {
                return response()->json([
                    'message' => 'Comercio no encontrado.'
                ], 404);
            }
            //Listamos todos los comercios
            return $commerce;
        }

        // Obtiene todos los registros si el campo deleted_at es null
        $commerce = Commerce::whereNull('deleted_at')
                            ->get();
        // Si no hay resultados, devolvemos 404
        if (!$commerce) {
            return response()->json([
                'message' => 'Comercio no encontrado.'
            ], 404);
        }
        //Listamos todos los comercios
        return $commerce;

    }

    // Devolver todos los comercios por ID (Ciertas condiciones aplican)
    public function show($id)
    {

        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Obtiene todos los registros si el campo deleted_at es null
            $commerce = Commerce::whereNull('deleted_at')
                                    // Filtrandolos por el user_id que coincida con el del usuario autenticado
                                    ->where(function($query) {
                                        $authUser = auth()->user();
                                        $query->where('user_id','=',$authUser->id);
                                    })
                                    ->find($id);
            // Si no hay resultados, devolvemos 404
            if (!$commerce) {
                return response()->json([
                    'message' => 'Comercio no encontrado.'
                ], 404);
            }
            //Listamos todos los comercios
            return $commerce;
        }

        //Bucamos el Comercio
        $commerce = Commerce::whereNull('deleted_at')
                            ->find($id);
        // Si el comercio no existe devolvemos error no encontrado
        if (!$commerce) {
            return response()->json([
                'message' => 'Comercio no encontrado.'
            ], 404);
        }
        // Si hay existe el comercio lo devolvemos
        return $commerce;

    }

    // Devolver el comercio por id con sus sucursales (Ciertas condiciones aplican)
    public function showOneCommerceWithBranchs($id){

        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Obtiene todos los registros si el campo deleted_at es null
            $commerce = DB::table('commerces as c')
                            ->join('branches as b', 'b.commerce_id', '=', 'c.id')
                            ->select(
                                'b.id', 'b.name', 'b.location', 'b.phone', 'b.branch_type', 'b.commerce_id',
                                'c.id as id_commerce', 'c.name as commerce_name', 'c.rif', 'c.email',
                                'c.phone as commerce_phone', 'c.password', 'c.user_id','c.deleted_at'
                            )
                            ->where('c.id', '=', $id)
                            ->where(function($deleted_at) {
                                $deleted_at->whereNull('c.deleted_at')
                                ->where(function($user_id) {
                                    $authUser = auth()->user();
                                    $user_id->where('c.user_id','=',$authUser->id);
                                });
                            })
                            ->get();
            // Si no hay resultados, devolvemos 404
            if (!$commerce) {
                return response()->json([
                    'message' => 'Comercio no encontrado.'
                ], 404);
            }
            //Listamos todos los comercios
            return $commerce;
        }


        // Buscamos un comercio y sus sucursales
        $commerce = DB::table('commerces as c')
                        ->join('branches as b', 'b.commerce_id', '=', 'c.id')
                        ->select(
                            'b.id', 'b.name', 'b.location', 'b.phone', 'b.branch_type', 'b.commerce_id',
                            'c.id as id_commerce', 'c.name as commerce_name', 'c.rif', 'c.email',
                            'c.phone as commerce_phone', 'c.password', 'c.user_id','c.deleted_at'
                        )
                        ->where('c.id', '=', $id)
                        ->where(function($commerce_deleted_at) {
                            $commerce_deleted_at->whereNull('c.deleted_at')
                            ->where(function($branch_deleted_at) {
                                $branch_deleted_at->whereNull('b.deleted_at');
                            });
                        })
                        ->get();

        // Si no hay resultados, devolvemos 404
        if (!$commerce) {
            return response()->json([
                'message' => 'Comercio no encontrado'
            ],404);
        }

        // Si existe el comercio lo devolvemos
        return $commerce;
    }

    // Devolver el comercio por id con sus afiliados (Ciertas condiciones aplican)
    public function showOneCommerceWithAffiliates($id){

        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Obtiene todos los registros si el campo deleted_at es null
            $commerce = DB::table('commerces as c')
                            ->join('affiliates as af', 'af.commerce_id', '=', 'c.id')
                            ->select(
                                'af.id as id_affiliate', 'af.affiliate', 'af.commerce_id', 'c.id as id_commerce',
                                'c.name', 'c.rif', 'c.email', 'c.phone', 'c.password'
                            )
                            ->where('c.id', '=', $id)
                            ->where(function($deleted_at) {
                                $deleted_at->whereNull('c.deleted_at')
                                ->where(function($user_id) {
                                    $authUser = auth()->user();
                                    $user_id->where('c.user_id','=',$authUser->id);
                                });
                            })
                            ->get();

            // Si no hay resultados, devolvemos 404
            if (!$commerce) {
                return response()->json([
                    'message' => 'Comercio no encontrado.'
                ], 404);
            }
            //Listamos todos los comercios
            return $commerce;
        }

        // Buscamos un comercio y sus sucursales
        $commerce = DB::table('commerces as c')
                        ->join('affiliates as af', 'af.commerce_id', '=', 'c.id')
                        ->select(
                            'af.id as id_affiliate', 'af.affiliate', 'af.commerce_id', 'c.id as id_commerce',
                            'c.name', 'c.rif', 'c.email', 'c.phone', 'c.password'
                        )
                        ->where('c.id', '=', $id)
                        ->where(function($commerce_deleted_at) {
                            $commerce_deleted_at->whereNull('c.deleted_at')
                            ->where(function($affiliate_deleted_at) {
                                $affiliate_deleted_at->whereNull('af.deleted_at');
                            });
                        })
                        ->get();
        // Si no hay resultados, devolvemos 404
        if (!$commerce) {
            return response()->json([
                'message' => 'Comercio no encontrado'
            ],404);
        }

        // Si existe el comercio lo devolvemos
        return $commerce;

    }

    public function store(Request $request)
    {
        // Validamos los datos
        $data = $request->only('name','rif','email','phone','password','user_id');
        $validator = Validator::make($data, [
            // Datos del Comercio
            'name'           => 'required|max:150|string',
            'rif'            => 'required|max:10|string',
            'email'          => 'required|email|unique:users',
            'phone'          => 'required|string|min:10|max:10',
            'password'       => 'required|string|min:6|max:50',
            'user_id'        => 'required',
        ]);

        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        // Creamos el comercio en la BD
        $commerce = Commerce::create([
            'name'     =>        $request->name,
            'rif'      =>        $request->rif,
            'email'    =>        $request->email,
            'phone'    =>        $request->phone,
            'password' =>        $request->password,
            'user_id'  =>        $request->user_id,
        ]);

        if($commerce){

            // Obtenemos el ultimo id insertado en la tabla de comercios
            $last_id = Commerce::latest('id')->first();
            $commerce_id = $last_id->id;

            // Creamos la sucursal en la BD
            $branch = Branch::create([
                'name' => "Principal",
                'location' => null,
                'branch_type' => "P",
                'phone' => $request->phone,
                'commerce_id' => $commerce_id,
            ]);

            // Respuesta en caso de que todo vaya bien.
            return response()->json([
                'message' => 'Comercio y Sucursal Principal Creadas con Éxito',
                'data_commerce' => $commerce,
                'data_branch' => $branch
            ], Response::HTTP_OK);
            // return true;
        }
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $data = $request->only('name','rif','email','phone','password','user_id');
        $validator = Validator::make($data, [
            'name'           => 'required|max:150|string',
            'rif'            => 'required|max:10|string',
            'email'          => 'required|email|unique:users',
            'phone'          => 'required|string',
            'password'       => 'required|string|min:6|max:50',
            'user_id'        => 'required',
        ]);

        // Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        // Buscamos el comercio
        $commerce = Commerce::findOrfail($id);
        // Actualizamos el comercio.
        $commerce->update([
            'name'     =>        $request->name,
            'rif'      =>        $request->rif,
            'email'    =>        $request->email,
            'phone'    =>        $request->phone,
            'password' => bcrypt($request->password),
            'user_id'  =>        $request->user_id,
        ]);
        // Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Comercio actualizado con éxito!',
            'data' => $commerce
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        // Usamos carbon para obtener la fecha
        $now = Carbon::now();

        // Buscamos el comercio
        $commerce = Commerce::findOrfail($id);

        // Eliminamos el comercio "aparentemente"
        $commerce->update([
            'deleted_at'=>$now,
        ]);
        // $commerce->delete();

        // Devolvemos la respuesta
        return response()->json([
            'message' => 'Comercio eliminado con éxito!'
        ], Response::HTTP_OK);
    }
}
