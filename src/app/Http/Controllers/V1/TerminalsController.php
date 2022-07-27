<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TerminalsController extends Controller
{
    public function index(){

        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Buscamos todas las terminales con su modelo y marca asociados
            $terminal = DB::table('terminals as t')
                        ->join('branches', 't.branch_id', '=', 'branches.id')
                        ->join('affiliates as af', 't.affiliate_id', '=', 'af.id')
                        ->join('commerces as c', 'af.commerce_id', '=', 'c.id')
                        ->join('det_lists as dt', 't.mark_id', '=', 'dt.id')
                        ->join('det_lists as dts', 't.model_id', '=', 'dts.id')
                        ->select(
                            't.id', 't.serial', 't.password', 't.vuelto', 't.reversoc2p',
                            't.status',  'c.name as name_commerce', 'branches.name as branch_name',
                            'af.affiliate', 't.mark_id', 't.model_id', 'dt.name as mark_model',
                            't.mark_id', 'dts.name as model_name', 't.model_id'
                        )
                        ->whereNull('t.deleted_at')
                        ->where(function($user_id) {
                            $authUser = auth()->user();
                            $user_id->where('c.user_id','=',$authUser->id);
                        })
                        ->orderByRaw('id')
                        ->get();
            // Si no existe devolvemos error no encontrado
            if(!$terminal){
                return response()->json([
                    'message' => 'Terminal no encontrada',
                    'data_terminal' => $terminal
                ],400);
            }
            // Si existe la terminal la devolvemos
            return $terminal;
        }

        // Buscamos todas las terminales con su modelo y marca asociados
        $terminal = DB::table('terminals as t')
            ->join('branches', 't.branch_id', '=', 'branches.id')
            ->join('affiliates as af', 't.affiliate_id', '=', 'af.id')
            ->join('commerces as c', 'af.commerce_id', '=', 'c.id')
            ->join('det_lists as dt', 't.mark_id', '=', 'dt.id')
            ->join('det_lists as dts', 't.model_id', '=', 'dts.id')
            ->select(
                't.id', 't.serial', 't.password', 't.vuelto', 't.reversoc2p',
                't.status',  'c.name as name_commerce', 'branches.name as branch_name',
                'af.affiliate', 't.mark_id', 't.model_id', 'dt.name as mark_model',
                't.mark_id', 'dts.name as model_name', 't.model_id'
            )
            ->whereNull('t.deleted_at')
            ->orderByRaw('id')
            ->get();
        // Si no existe devolvemos error no encontrado
        if(!$terminal){
            return response()->json([
                'message' => 'Sin Terminales Registradas',
                'data_terminal' => $terminal
            ],400);
        }
        // Si existe la terminal la devolvemos
        return $terminal;
    }


    public function show($id){
        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Buscamos todas las terminales con su modelo y marca asociados
            $terminal = DB::table('terminals as t')
                    ->join('branches', 't.branch_id', '=', 'branches.id')
                    ->join('affiliates as af', 't.affiliate_id', '=', 'af.id')
                    ->join('commerces as c', 'af.commerce_id', '=', 'c.id')
                    ->join('det_lists as dt', 't.mark_id', '=', 'dt.id')
                    ->join('det_lists as dts', 't.model_id', '=', 'dts.id')
                    ->select(
                        't.id', 't.serial', 't.password', 't.vuelto', 't.reversoc2p', 't.status',
                        'c.name as name_commerce', 'branches.name as branch_name', 'c.rif as rif_commerce',
                        'c.phone as phone_commerce', 'c.email as email_commerce', 'af.affiliate',
                        't.mark_id', 't.model_id', 'dt.name as mark_model', 't.mark_id',
                        'dts.name as model_name', 't.model_id', 'c.id as id_commerce'
                    )
                    ->where('t.id','=',$id)
                    ->whereNull('t.deleted_at')
                    ->where(function($user_id) {
                        $authUser = auth()->user();
                        $user_id->where('c.user_id','=',$authUser->id);
                    })
                    ->orderByRaw('id')
                    ->get();

            // Si no existe devolvemos error no encontrado
            if(!$terminal){
                return response()->json([
                    'message' => 'Terminal no encontrada',
                    'data_terminal' => $terminal
                ],400);
            }
            // Si existe la terminal la devolvemos
            return $terminal;
        }

        // Buscamos la terminal con su modelo y marca asociados
        $terminal = DB::table('terminals as t')
                    ->join('branches', 't.branch_id', '=', 'branches.id')
                    ->join('affiliates as af', 't.affiliate_id', '=', 'af.id')
                    ->join('commerces as c', 'af.commerce_id', '=', 'c.id')
                    ->join('det_lists as dt', 't.mark_id', '=', 'dt.id')
                    ->join('det_lists as dts', 't.model_id', '=', 'dts.id')
                    ->select(
                        't.id', 't.serial', 't.password', 't.vuelto', 't.reversoc2p', 't.status',
                        'c.name as name_commerce', 'branches.name as branch_name', 'c.rif as rif_commerce',
                        'c.phone as phone_commerce', 'c.email as email_commerce', 'af.affiliate',
                        't.mark_id', 't.model_id', 'dt.name as mark_model', 't.mark_id',
                        'dts.name as model_name', 't.model_id', 'c.id as id_commerce'
                    )
                    ->where('t.id','=',$id)
                    ->whereNull('t.deleted_at')
                    ->orderByRaw('id')
                    ->get();

        // Si no existe devolvemos error no encontrado
        if(!$terminal){
            return response()->json([
                'message' => 'Terminal no encontrada',
                'data_terminal' => $terminal
            ],400);
        }
        // Si existe la terminal la devolvemos
        return $terminal;
    }

    public function getTerminalBySerial($serial) {

        $authUser = auth()->user();

        // Filtro aplicado al perfil user
        if ($authUser->profile_id == 2) {
            // Buscamos todas las terminales con su modelo y marca asociados
            $terminal = DB::table('terminals as t')
                            ->join('affiliates as af', 't.affiliate_id', '=', 'af.id')
                            ->join('commerces as c', 'af.commerce_id', '=', 'c.id')
                            ->select(
                                't.serial', 'c.name as name_commerce', 'c.phone', 'c.rif',
                                'c.email', 't.vuelto', 't.reversoc2p', 'af.affiliate as name_affiliate',
                                't.password','t.deleted_at'
                            )
                            ->where('t.serial', '=', $serial)
                            ->whereNull('t.deleted_at')
                            ->where(function($user_id) {
                                $authUser = auth()->user();
                                $user_id->where('c.user_id','=',$authUser->id);
                            })
                            ->orderByRaw('serial')
                            ->get();

            // Si no existe devolvemos error no encontrado
            if(!$terminal){
                return response()->json([
                    'message' => 'Terminal no encontrada',
                    'data_terminal' => $terminal
                ],400);
            }
            // Si existe la terminal la devolvemos
            return $terminal;
        }

        // Buscamos la terminal con su modelo y marca asociados
        $terminal = DB::table('terminals as t')
                    ->join('affiliates as af', 't.affiliate_id', '=', 'af.id')
                    ->join('commerces as c', 'af.commerce_id', '=', 'c.id')
                    ->select(
                        't.serial', 'c.name as name_commerce', 'c.phone', 'c.rif',
                        'c.email', 't.vuelto', 't.reversoc2p', 'af.affiliate as name_affiliate',
                        't.password','t.deleted_at'
                    )
                    ->where('t.serial', '=', $serial)
                    ->whereNull('t.deleted_at')
                    ->orderByRaw('serial')
                    ->get();

        // Si no existe devolvemos error no encontrado
        if(!$terminal){
            return response()->json([
                'message' => 'Terminal no encontrada',
                'data_terminal' => $terminal
            ],400);
        }
        // Si existe la terminal la devolvemos
        return $terminal;
    }

    public function store(Request $request){
        // Obtenemos los datos
        $data = $request->only('serial', 'password', 'vuelto', 'reversoc2p', 'status', 'model_id', 'mark_id', 'branch_id', 'affiliate_id' );
        // Validamos los datos
        $validator = Validator::make($data, [
            'serial'        => 'required|max:50|string|unique:terminals',
            'vuelto'        => 'required',
            'reversoc2p'    => 'required',
            'status'        => 'required|string',
            'password'      => 'required',
            'model_id'      => 'required',
            'mark_id'       => 'required',
            'branch_id'     => 'required',
            'affiliate_id'  => 'required'
        ]);
        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        // Creamos la terminal en la BD
        $terminal = Terminal::create([
            'serial'          => $request->serial,
            'vuelto'          => $request->vuelto,
            'reversoc2p'      => $request->reversoc2p,
            'status'          => $request->status,
            'password'        => $request->password,
            'model_id'        => $request->model_id,
            'mark_id'         => $request->mark_id,
            'branch_id'       => $request->branch_id,
            'affiliate_id'    => $request->affiliate_id,
        ]);

        // Respuesta en caso de que todo vaya bien
        return response()->json([
            'message' => 'Terminal Creado con Éxito',
            'data_in_terminal'    => $terminal,
        ],Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $data = $request->only('serial', 'password', 'vuelto', 'reversoc2p', 'status', 'model_id', 'mark_id', 'branch_id', 'affiliate_id' );
        $validator = Validator::make($data, [
            'serial'        => 'required|max:50|string',
            'vuelto'        => 'required',
            'reversoc2p'    => 'required',
            'status'        => 'required|string',
            'password'      => 'required',
            'model_id'      => 'required',
            'mark_id'       => 'required',
            'branch_id'     => 'required',
            'affiliate_id'  => 'required'
        ]);

        // Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        // Buscamos el comercio
        $terminal = Terminal::findOrfail($id);
        // Actualizamos el comercio.
        $terminal->update([
            'serial'          => $request->serial,
            'vuelto'          => $request->vuelto,
            'reversoc2p'      => $request->reversoc2p,
            'status'          => $request->status,
            'password'        => $request->password,
            'model_id'        => $request->model_id,
            'mark_id'         => $request->mark_id,
            'branch_id'       => $request->branch_id,
            'affiliate_id'    => $request->affiliate_id,
        ]);
        // Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Terminal actualizada con éxito!',
            'data' => $terminal
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        // Usamos carbon para obtener la fecha
        $now = Carbon::now();

        // Buscamos la terminal
        $terminal = Terminal::findOrfail($id);

        // Eliminamos la terminal "aparentemente"
        $terminal->update([
            'deleted_at'=>$now,
        ]);
        // $terminal->delete();

        // Devolvemos la respuesta
        return response()->json([
            'message' => 'Terminal eliminada con éxito!'
        ], Response::HTTP_OK);
    }
}
