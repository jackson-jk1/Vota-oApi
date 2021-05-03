<?php

namespace App\Http\Controllers;
use App\Models\Enquete;
use App\Models\Opcao;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
         return view('welcome');
    }
    public function show()
    {
        $enquetes = Enquete::all();
        return response()->json(['enquetes'=>$enquetes]);
    }
    public function view($id)
    {
        if($id != Auth::user()->getAuthIdentifier()){
            return response()->json(['erro' => 'Voce não possui autorização para realizar essa operação'],404);
        }

        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('Y-m-d H:i:s');

       DB::table('enquetes')->
        where('inicio','<',$hoje)->
        where('fim','>',$hoje)
            ->chunkById(100, function ($enquetes) {
                foreach ($enquetes as $enquete) {
                    DB::table('enquetes')
                        ->where('id', $enquete->id)
                        ->update(['status' => Enquete::ATIVO]);
            }
        });
        DB::table('enquetes')->
        where('inicio','>',$hoje)->
        where('fim','>',$hoje)
            ->chunkById(100, function ($enquetes) {
                foreach ($enquetes as $enquete) {
                    DB::table('enquetes')
                        ->where('id', $enquete->id)
                        ->update(['status' => Enquete::NOVA]);
                }
            });
        DB::table('enquetes')->
        where('fim','<',$hoje)
            ->chunkById(100, function ($enquetes) {
                foreach ($enquetes as $enquete) {
                    DB::table('enquetes')
                        ->where('id', $enquete->id)
                        ->update(['status' => Enquete::FINALIZADA]);
                }
            });
        $enquetes = Enquete::all()->where('id_user',Auth::user()->getAuthIdentifier());
        return response()->json(['enquetes'=>$enquetes]);
    }
}


