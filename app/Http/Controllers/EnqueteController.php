<?php

namespace App\Http\Controllers;

use App\Models\Enquete;
use App\Models\Opcao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class EnqueteController extends Controller
{
    public function index()
    {
        $enquetes =  Enquete::all();

        return response()->json(['enquetes'=>$enquetes]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'titulo' => 'required|max:255|string',
            'inicio' => 'required|date',
            'horaN' => 'required',
            'horaF' => 'required',
            'fim'   => 'required|date',
        ]);

        if ($validator->fails()){
            return response()->json(['erro' => $validator->errors()],404);
        }

        $enquete = new Enquete();
        $enquete->id_user = Auth::user()->getAuthIdentifier();
        $inicio= $request->inicio." ".$request->horaN.":60";
        $fim = $request->fim." ".$request->horaF.":60";
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('Y-m-d H:i:s');

        if(strtotime($inicio) >= strtotime($fim)){
            return response()->json(['erro' =>'Data inicial maior que Data final'],404);
         }
        if(strtotime($inicio) < strtotime($hoje)){
            return response()->json(['erro' =>'Data inicial invalida'],404);
        }

        $inicio = Carbon::parse($inicio)->format('Y-m-d H:i:s');
        $fim = Carbon::parse($fim)->format('Y-m-d H:i:s');
        $enquete->titulo = $request->titulo;
        $enquete->inicio = $inicio;
        $enquete->fim = $fim;
        if ($request->quant > 5){
            return response()->json(['erro' => 'Utrapassou o numero maximo de questoes Permitidas'],404);
        }
        $enquete->respostas = $request->quant;
        $enquete->save();

        for ($i = 1; $i <= $request->quant; $i++){
            $validator = Validator::make($request->all(), [

                'resposta.*' => 'required|string',
            ]);
            if ($validator->fails()){
                Opcao::where('id_enquete','=',$enquete->id)->delete();
                $enquete->delete();
                return response()->json(['erro' => 'há menos de 3 opçoes para a enquete'],404);
            }
            $opcao = new Opcao();
            $opcao->id_enquete = $enquete->id;
            $opcao->titulo = $request->resposta[$i];
            $opcao->votos = 0;
            $opcao->save();
        }

        return response()->json(['sucesso' => 'cadatrado com sucesso'],200);

    }

    public function update(Request $request, $id)

    {

        $validator = Validator::make($request->all(), [

            'titulo' => 'required|max:255',
            'inicio' => 'required|max:255',
            'fim'   => 'required|max:255',
        ]);

        if ($validator->fails()){
            return response()->json(['erro' => $request->all()],404);
        }
        $enquete = Enquete::find($id);
        $enquete->update();
        $inicio= $request->inicio;
        $fim = $request->fim;
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('Y-m-d H:i:s');
        if(strtotime($inicio) > strtotime($fim)){
            return response()->json(['erro' =>'Data inicial maior que Data final'],404);
        }
        if(strtotime($inicio) < strtotime($hoje)){
            return response()->json(['erro' =>'Data inicial invalida'],404);
        }
        $inicio = Carbon::parse($request->inicio)->format('Y-m-d H:i:s');
        $fim = Carbon::parse($request->fim)->format('Y-m-d H:i:s');
        $enquete->titulo = $request->titulo;
        $enquete->inicio = $inicio;
        $enquete->fim = $fim;
        $enquete->save();
        return $enquete;
    }


    public function destroy($id)
    {
        $enquete = Enquete::find($id);
        Opcao::where('id_enquete','=',$id)->delete();
        $enquete->delete();

    }
}
