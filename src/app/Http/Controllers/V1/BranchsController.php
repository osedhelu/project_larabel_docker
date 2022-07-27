<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class BranchsController extends Controller
{
    public function index() {
        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Obtiene todos los registros si el campo deleted_at es null
            $branch = DB::table('branches as b')
                        ->join('commerces as c', 'b.commerce_id', '=', 'c.id')
                        ->select(
                            'c.id as id_commerce', 'c.name as commerce_name','c.rif','c.email',
                            'c.phone as commerce_phone','c.password','b.id','b.name','b.location',
                            'b.phone','b.branch_type','b.commerce_id'
                        )
                        ->whereNull('b.deleted_at')
                        // Filtrandolos por el user_id que coincida con el del usuario autenticado
                        ->where(function($query) {
                            $authUser = auth()->user();
                            $query->where('c.user_id','=',$authUser->id);
                        })
                        ->orderByRaw('b.id')
                        ->get();

            // Si no hay resultados, devolvemos 404
            if (!$branch) {
                return response()->json([
                    'message' => 'Sucursal no encontrada.'
                ], 404);
            }
            //Listamos todos las sucursales
            return $branch;
        }

        // Buscamos todas las sucursales con sus comercios asociados
        $branch = DB::table('branches as b')
                    ->join('commerces as c', 'b.commerce_id', '=', 'c.id')
                    ->select(
                        'c.id as id_commerce', 'c.name as commerce_name','c.rif','c.email',
                        'c.phone as commerce_phone','c.password','b.id','b.name','b.location',
                        'b.phone','b.branch_type','b.commerce_id'
                    )
                    ->whereNull('b.deleted_at')
                    ->orderByRaw('b.id')
                    ->get();

        return $branch;
    }

    public function show($id) {
        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Obtiene todos los registros si el campo deleted_at es null
            $branch = DB::table('branches as b')
                    ->join('commerces as c', 'b.commerce_id', '=', 'c.id')
                    ->select(
                        'c.id as id_commerce', 'c.name as commerce_name','c.rif','c.email',
                        'c.phone as commerce_phone','c.password','b.id','b.name','b.location',
                        'b.phone','b.branch_type','b.commerce_id'
                    )
                    ->where('b.id','=',$id)
                    ->whereNull('b.deleted_at')
                        // Filtrandolos por el user_id que coincida con el del usuario autenticado
                        ->where(function($query) {
                            $authUser = auth()->user();
                            $query->where('c.user_id','=',$authUser->id);
                        })
                    ->orderByRaw('b.id')
                    ->get();

            // Si no hay resultados, devolvemos 404
            if (!$branch) {
                return response()->json([
                    'message' => 'Sucursal no encontrada.'
                ], 404);
            }
            //Listamos todos las sucursales
            return $branch;
        }

        // Buscamos la sucursal con su comercio asociado
        $branch = DB::table('branches as b')
                    ->join('commerces as c', 'b.commerce_id', '=', 'c.id')
                    ->select(
                        'c.id as id_commerce', 'c.name as commerce_name','c.rif','c.email',
                        'c.phone as commerce_phone','c.password','b.id','b.name','b.location',
                        'b.phone','b.branch_type','b.commerce_id'
                    )
                    ->where('b.id','=',$id)
                    ->orderByRaw('b.id')
                    ->get();

        // Si no existe devolvemos error no encontrado
        if(!$branch){
            return response()->json([
                'message' => 'Sucursal no encontrada',
                'data_in_branch' => $branch
            ],400);
        }
        // Si existe la sucursal la devolvemos
        return $branch;
    }

    public function store(Request $request){
        // Obtenemos los datos
        $data = $request->only('name','location','phone','branch_type','commerce_id');

        // Validamos los datos
        $validator = Validator::make($data, [
            'name'             => 'required|max:150|string',
            'location'         => 'required|max:300',
            'phone'            => 'required|max:10',
            'branch_type'      => 'required|in:P,S',
            'commerce_id'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()],400);
        }

        $branch = Branch::create([
            'name'        => $request->name,
            'location'    => $request->location,
            'phone'       => $request->phone,
            'branch_type' => $request->branch_type,
            'commerce_id' => $request->commerce_id
        ]);

        // Respuesta en caso de que todo vaya bien
        return response()->json([
            'message' => 'Sucursal Creada con Éxito',
            'data_in_branch' => $branch
        ],Response::HTTP_OK);
    }

    public function update (Request $request, $id) {
        // Validacion de datos
        $data = $request->only('name','location','phone','branch_type','commerce_id');

        // Validamos los datos
        $validator = Validator::make($data, [
            'name'             => 'required|max:150|string',
            'location'         => 'required|max:300',
            'phone'            => 'required|max:10',
            'branch_type'      => 'required|in:P,S',
            'commerce_id'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()],400);
        }

        // Buscamos la sucursal
        $branch = Branch::findOrfail($id);
        // Actualizamos la sucursal
        $branch->update([
            'name'        => $request->name,
            'location'    => $request->location,
            'phone'       => $request->phone,
            'branch_type' => $request->branch_type,
            'commerce_id' => $request->commerce_id
        ]);
        // Devolvemos los datos actualizados
        return response()->json([
            'message' => 'Sucursal actualizada con Éxito',
            'data_in_branch' => $branch
        ],Response::HTTP_OK);
    }

    public function destroy($id) {
        // Usamos carbon para obtener la fecha
        $now = Carbon::now();

        // Buscamos la sucursal
        $branch = Branch::findOrfail($id);

        // Eliminamos la sucursal "aparentemente"
        $branch->update([
            'deleted_at'=>$now,
        ]);
        // $branch->delete();

        // Devolvemos la respuesta
        return response()->json([
            'message' => 'Sucursal eliminada con Éxito'
        ],Response::HTTP_OK);
    }
}
