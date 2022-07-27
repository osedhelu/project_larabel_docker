<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionsController extends Controller
{
    //
    public function index(){
        $transaction = DB::table('transactions as ts')
        ->join('terminals as t', 'ts.terminal_id','=','t.id')
        ->select('ts.*','t.*')
        ->get();

        return $transaction;
    }

    public function show($id){
        // Buscamos la transacción
        $transaction = DB::table('transactions as ts')
        ->join('terminals as t', 'ts.terminal_id','=','t.id')
        ->select('ts.*','t.*')
        ->where('ts.id', '=', $id)
        ->get();

        if(!$transaction){
            return response()->json([
                'message' => 'Transacción no encontrada',
                'data_in_transaction' => $transaction
            ],400);
        }

        // Si existe el afiliado, lo devolvemos
        return $transaction;
    }

    public function store(Request $request){
        // Obtenemos los datos
        $data = $request->only('bank','client_phone','client_affiliate','amount','date','hour','reference','reason','terminal_id');

        // Validamos los datos
        $validator = Validator::make($data, [
            'bank'             => 'required|max:150|string',
            'client_phone'     => 'required|min:9|max:9',
            'client_affiliate' => 'required|min:9|max:9',
            'amount'           => 'required',
            'date'             => 'required',
            'hour'             => 'required',
            'reference'        => 'required|max:300|string',
            'reason'           => 'required|max:150|string',
            'terminal_id'      => 'required'
        ]);

        //  Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error',$validator->messages()],
            400);
        }

        // Creamos la transacción en la BD
        $transaction = Transaction::create([
            'bank'             => $request->bank,
            'client_phone'     => $request->client_phone,
            'client_affiliate' => $request->client_affiliate,
            'amount'           => $request->amount,
            'date'             => $request->date,
            'hour'             => $request->hour,
            'reference'        => $request->reference,
            'reason'           => $request->reason,
            'terminal_id'      => $request->terminal_id
        ]);

        // Respuesta en caso de que todo vaya bien
        return response()->json([
            'message' => 'Transacción creada con Éxito',
            'data_in_transaction' => $transaction
        ],Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        // Obtenemos los datos
        $data = $request->only('bank','client_phone','client_affiliate','amount','date','hour','reference','reason','terminal_id');

        // Validamos los datos
        $validator = Validator::make($data, [
            'bank'             => 'required|max:150|string',
            'client_phone'     => 'required|min:9|max:9',
            'client_affiliate' => 'required|min:9|max:9',
            'amount'           => 'required',
            'date'             => 'required',
            'hour'             => 'required',
            'reference'        => 'required|max:300|string',
            'reason'           => 'required|max:150|string',
            'terminal_id'      => 'required'
        ]);

        //  Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error',$validator->messages()],
            400);
        }

        // Buscamos la transacción
        $transaction = Transaction::findOrfail($id);
        $transaction->update([
            'bank'             => $request->bank,
            'client_phone'     => $request->client_phone,
            'client_affiliate' => $request->client_affiliate,
            'amount'           => $request->amount,
            'date'             => $request->date,
            'hour'             => $request->hour,
            'reference'        => $request->reference,
            'reason'           => $request->reason,
            'terminal_id'      => $request->terminal_id
        ]);
        // Devolvemos los datos actualizados
        return response()->json([
           'message'  => 'Transacción actualizada con Éxito',
           'data_in_transaction' => $transaction
        ], Response::HTTP_OK);

    }

    public function destroy($id){
        $now = Carbon::now();

        // Buscamos la transacción
        $transaction = Transaction::findOrfail($id);

        // Eliminamos la transacción "aparentemente"
        $transaction->update([
            'deleted_at'=>$now
        ]);
        // $transaction->delete();

        // Devolvemos la respuesta
        return response()->json([
            'message' => 'Transacción eliminada con éxito'
        ], Response::HTTP_OK);
    }
}
