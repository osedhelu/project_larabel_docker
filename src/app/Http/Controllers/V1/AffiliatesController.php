<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use JWTAuth;
use Carbon\Carbon;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AffiliatesController extends Controller
{
    public function index(){
        // Buscamos todos los afiliados con su comercio
        $affiliate = DB::table('affiliates as af')
                    ->join('commerces as c', 'af.commerce_id', '=', 'c.id')
                    ->select(
                        'af.id as id_affiliate', 'af.affiliate', 'af.commerce_id',
                        'c.id as id_commerce', 'c.name', 'c.rif', 'c.email', 'c.phone',
                        'c.password'
                    )
                    ->whereNull('af.deleted_at')
                    ->get();

        return $affiliate;
    }

    public function show($id){
        // Buscamos el afiliado y su comercio
        $affiliate = DB::table('affiliates as af')
                        ->join('commerces as c', 'af.commerce_id', '=', 'c.id')
                        ->select(
                            'af.id','af.affiliate','af.created_at as affiliate_created','af.updated_at as affiliate_updated_at',
                            'af.deleted_at as affiliate_deleted_at','af.commerce_id','c.id as id_commerce','c.name','c.rif',
                            'c.email','c.phone','c.password','c.user_id'
                        )
                        ->whereNull('af.deleted_at')
                        ->where('af.id', '=', $id)
                        ->get();

        if(!$affiliate){
            return response()->json([
                'message' => 'Afiliado no encontrado',
                'data_in_affiliate' => $affiliate
            ],400);
        }

        // Si existe el afiliado, lo devolvemos
        return $affiliate;
    }


    public function store(Request $request){
        // Obtenemos los datos
        $data = $request->only('affiliate', 'commerce_id');
        // Validamos los datos
        $validator = Validator::make($data, [
            'affiliate'        => 'required|max:150|string|unique:affiliates',
            'commerce_id'      => 'required',
        ]);
        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        // Creamos la terminal en la BD
        $affiliate = Affiliate::create([
            'affiliate'       => $request->affiliate,
            'commerce_id'     => $request->commerce_id,
        ]);

        // Respuesta en caso de que todo vaya bien
        return response()->json([
            'message' => 'Afiliado Creado con Éxito',
            'data_in_affiliate'    => $affiliate,
        ],Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        // Validacion de datos
        $data = $request->only('affiliate','commerce_id');
        $validator = Validator::make($data, [
            'affiliate' => 'required|max:150|string',
            'commerce_id'      => 'required',
        ]);

        // Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()],400);
        }

        // Buscamos el afiliado
        $affiliate = Affiliate::findOrfail($id);
        // Actualizamos el afiliado
        $affiliate->update([
            'affiliate'     => $request->affiliate,
            'commerce_id'   => $request->commerce_id
        ]);
        // Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Afiliado actualizado con éxito.',
            'data'    => $affiliate
        ], Response::HTTP_OK);
    }

    public function destroy($id) {
        $now = Carbon::now();

        // Buscamos el afiliado
        $affiliate = Affiliate::findOrfail($id);

        // Eliminamos el afiliado "aparentemente"
        $affiliate->update([
            'deleted_at'=>$now
        ]);
        // $affiliate->delete();

        // Devolvemos la respuesta
        return response()->json([
            'message' => 'Afiliado eliminado con éxito'
        ], Response::HTTP_OK);
    }
}
