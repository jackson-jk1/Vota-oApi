<?php

namespace App\Http\Controllers;
use App\Models\Enquete;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Opcao;
use Illuminate\Http\Request;

class OpcaoController extends Controller
{

        public function view($id)
    {

        $opcao = Opcao::all()->where('id_enquete',$id);
        $opN = $opcao->count();
        return response()->json(['opcoes' => $opcao, 'opN' => $opN]);
    }


    public function store(Request $request , $id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|max:255',

        ]);
        if ($validator->fails()){
            return response()->json(['erro' => $request->all()],404);
        }
        $enquete = Enquete::find($id);

        if($enquete->id_user != Auth::user()->getAuthIdentifier()){
            return response()->json(['erro' => 'voce nao possui autorização para realizar essa operação'],404);
        }
        $opcao = new Opcao();
        $opcao->id_enquete = $id;
        $opcao->titulo = $request->titulo;
        $opcao->votos = 0;
        $opcao->save();
        return $opcao;
    }
    public function voto($id){
        $voto = Opcao::find($id);
        $voto->update();
        $voto->votos+=1;
        $voto->save();
        $opcao = Opcao::all()->where('id_enquete',$voto->id_enquete);
        return response()->json(['opcoes' => $opcao]);
    }

    public function update(Request $request ,$id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|max:255',

        ]);
        if ($validator->fails()){
            return response()->json(['erro' => $request->all()],404);
        };

        $opcao = Opcao::find($id);
        $id_enquete = $opcao->id_enquete;
        $enquete = Enquete::find($id_enquete);
        if($enquete->id_user != Auth::user()->getAuthIdentifier()){
            return response()->json(['erro' => 'voce nao possui autorização para realizar essa operação'],404);
        }
        $opcao->update();
        $opcao->titulo = $request->titulo;
        $opcao->save();
        return $opcao;
    }

    public function destroy($id)
    {
        $opcao = Opcao::find($id);
        $id_enquete = $opcao->id_enquete;
        $enquete = Enquete::find($id_enquete);
        if($enquete->id_user != Auth::user()->getAuthIdentifier()){
            return response()->json(['erro' => 'voce nao possui autorização para realizar essa operação'],404);
        }
        $opcao->delete();
    }
}
