<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Evento;
use App\Trabalho;
use App\Participante;
use App\FuncaoParticipantes;
use Auth;

class ParticipanteController extends Controller
{
    public function index(){

    	return view('participante.index');
    }
    public function editais(){

        $eventos = Evento::all();
        return view('participante.editais', ['eventos'=> $eventos] );
    }

    public function edital($id){
        $edital = Evento::find($id);
        $trabalhosId = Trabalho::where('evento_id', '=', $id)->select('id')->get();
        $meusTrabalhosId = Participante::where('user_id', '=', Auth()->user()->id)
            ->whereIn('trabalho_id', $trabalhosId)->select('trabalho_id')->get();
        $projetos = Trabalho::whereIn('id', $meusTrabalhosId)->get();
        //$projetos = Auth::user()->participantes->where('user_id', Auth::user()->id)->first()->trabalhos;


        //dd(Auth::user()->proponentes);

        return view('participante.projetos')->with(['edital' => $edital, 'projetos' => $projetos]);
    }

    public function storeFuncao(Request $request) {
        $validated = $request->validate([
            'newFuncao'      => 'required',
            'nome_da_função' => 'required',
        ]);

        $funcao = new FuncaoParticipantes();
        $funcao->nome = $request->input('nome_da_função');

        $funcao->save();

        return redirect()->back()->with(['mensagem' => 'Função de participante cadastrada com sucesso!']);
    }

    public function updateFuncao(Request $request, $id) {
        $validated = $request->validate([
            'editFuncao' => 'required',
            'nome_da_função'.$id => 'required',
        ]);

        $funcao = FuncaoParticipantes::find($id);
        if ($funcao->participantes->count() > 0) {
            return redirect()->back()->with(['error' => 'Essa função não pode ser editada pois participantes estão vinculados a ela!']);
        }

        $funcao->nome = $request->input('nome_da_função'.$id);
        $funcao->update();

        return redirect()->back()->with(['mensagem' => 'Função de participante salva com sucesso!']);
    }

    public function destroyFuncao($id) {
        $funcao = FuncaoParticipantes::find($id);
        if ($funcao->participantes->count() > 0) {
            return redirect()->back()->with(['error' => 'Essa função não pode ser excluída pois participantes estão vinculados a ela!']);
        }

        $funcao->delete();
        return redirect()->back()->with(['mensagem' => 'Função de participante deletada com sucesso!']);
    }

    public function baixarDocumento(Request $request) {

        if (Storage::disk()->exists($request->pathDocumento)) {
            ob_end_clean();
            return Storage::download($request->pathDocumento);
        }
        return abort(404);
    }
}
