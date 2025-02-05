@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('sucesso'))
            <div class="alert alert-success" role="alert">
                {{ session('sucesso') }}
            </div>
        @endif
        @if(session('erro'))
            <div class="alert alert-danger" role="alert">
                {{ session('erro') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card" style="margin-top:50px">
                    <div class="card-header">
                        <h4 class="card-title" style= "color:#1492E6">
                            Substituir Participante
                        </h4>
                        <h5 style= "color:grey; font-size:medium">{{$edital->nome}}: {{$projeto->titulo}}</h5>
                    </div>
                    <div class="card-body">
                        <h4>Formação Atual</h4>
                        <div style="margin-top: 20px">
                            <div class="card-header">
                                <h5 class="card-title" style= "color:#1492E6">
                                    Nome/Periodo
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach($participantes as $participante)
                                    <div class="row"style="margin-bottom: 20px;">
                                        <div class="col-10">
                                            <h4 style="font-size:20px">{{$participante->user->name}}</h4>
                                            <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($participante->created_at))}} - Atualmente</h5>
                                        </div>
                                        <div class="col-2 align-self-center">
                                            <div class="row justify-content-around">
                                                <a href="" data-toggle="modal" data-target="#modalSubParticipante{{$participante->id}}" class="button"><i class="fas fa-exchange-alt fa-2x"></i><a>
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$participante->id}}" class="button"><i class="far fa-eye fa-2x"></i></a> 
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Modal substituir participante -->
                                    <div class="modal fade" id="modalSubParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Novo participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body px-1">
                                                    @include('administrador.substituirParticipanteForm')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal visualizar informações participante -->
                                    <div class="modal fade" id="modalVizuParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    @include('administrador.substituirParticipanteForm', ['visualizarOnly' => 1])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <h4 style="margin-top: 50px">Substituições</h4>
                        <div style="margin-top: 20px">
                            <div class="card-header">
                                <div class="row">
                                        <div class="col-4">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Participante Substituido
                                            </h5>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Participante Substituto
                                            </h5>
                                        </div>
                                        <div class="col-2">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Tipo
                                            </h5>
                                        </div>
                                        <div class="col-2">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Status
                                            </h5>
                                        </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @foreach($substituicoesProjeto as $subs)
                                    <div class="row"style="margin-bottom: 20px;">
                                            <div class="col-4">
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</h4></a>
                                                <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->created_at))}} - @if($subs->participanteSubstituido()->withTrashed()->first()->deleted_at == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->deleted_at))}} @endif</h5>
                                            </div>
                                            <div class="col-4">
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</h4></a>
                                                <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->created_at))}} - @if($subs->participanteSubstituto()->withTrashed()->first()->deleted_at == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->deleted_at))}} @endif</h5>
                                            </div>
                                            <div class="col-2">
                                                @if($subs->tipo == 'ManterPlano')
                                                    <h5>Manter Plano</h5>
                                                @elseif($subs->tipo == 'TrocarPlano')
                                                    <h5>Alterar Plano</h5> 
                                                @elseif($subs->tipo == 'Completa')
                                                    <h5>Completa</h5> 
                                                @endif
                                            </div>
                                            <div class="col-2">
                                                @if($subs->status == 'Finalizada')
                                                    <h5>Concluída</h5>
                                                @elseif($subs->status == 'Negada')
                                                    <h5>Negada</h5> 
                                                @elseif($subs->status == 'Em Aguardo')
                                                    <h5>Pendente</h5> 
                                                @endif
                                            </div>
                                    </div>

                                    <!-- Modal vizualizar info participante substituido -->
                                    <div class="modal fade" id="modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header" style="overflow-x:auto">
                                                        <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        @include('administrador.vizualizarParticipante', ['visualizarSubstituido' => 1])
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <!-- Modal vizualizar info participante substituto -->
                                    <div class="modal fade" id="modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header" style="overflow-x:auto">
                                                        <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        @include('administrador.vizualizarParticipante')
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    $(document).ready(function(){
        $('input.cep:text').mask('00000-000');
        $('input.cpf:text').mask('000.000.000-00');
        $('input.celular').mask('(00) 00000-0000');

        $('input').on("input", function(){
            var maxlength = $(this).attr("maxlength");
            var currentLength = $(this).val().length;
            var idInput = $(this).attr("id");
            if( currentLength >= maxlength ){
                $("#caracsRestantes"+idInput).html("Caracteres restantes: " + (maxlength - this.value.length));
            }else if(currentLength == 0){
                $("#caracsRestantes"+idInput).html("");
            }else{
                $("#caracsRestantes"+idInput).html("Caracteres restantes: " + (maxlength - this.value.length));
            }
        });

        $("input[type='file']").on("change", function () {
            if(this.files[0].type.split('/')[1] == "pdf") {
                if(this.files[0].size > 20000000){
                    alert("O arquivo possui o tamanho superior a 2MB!");
                    $(this).val('');
                }
            }else{
                alert("O arquivo não é de tipo PDF!");
                $(this).val('');
            }
        });
    });

    function manterPlano(checkBox){
        var checkboxInput = checkBox;
        var idParticipante = checkboxInput.id;
        var tituloPlano = document.getElementById('nomePlanoTrabalho'+idParticipante);
        var anexoPlano = document.getElementById('anexoPlanoTrabalho'+idParticipante);

        if(checkboxInput.checked){
            tituloPlano.setAttribute('disabled', 'disabled');
            tituloPlano.removeAttribute('required');

            anexoPlano.setAttribute('disabled', 'disabled');
            anexoPlano.removeAttribute('required');
        }else if(!checkboxInput.checked){
            tituloPlano.removeAttribute('disabled');
            tituloPlano.setAttribute('required', 'required');

            anexoPlano.removeAttribute('disabled');
            anexoPlano.setAttribute('required', 'required');
        }
    }

    function substituirApenasPlano(checkBox){
        var checkboxInput = checkBox;
        var checkBoxId = checkboxInput.id;
        var idParticipante = checkBoxId.slice(11);
        var inputsForm = [];

        inputsForm.push(document.getElementById('nome'+idParticipante));
        inputsForm.push(document.getElementById('email'+idParticipante));
        inputsForm.push(document.getElementById('nascimento'+idParticipante));
        inputsForm.push(document.getElementById('cpf'+idParticipante));
        inputsForm.push(document.getElementById('rg'+idParticipante));
        inputsForm.push(document.getElementById('cep'+idParticipante));
        inputsForm.push(document.getElementById('celular'+idParticipante));
        inputsForm.push(document.getElementById('linkLattes'+idParticipante));
        inputsForm.push(document.getElementById('estado'+idParticipante));
        inputsForm.push(document.getElementById('cidade'+idParticipante));
        inputsForm.push(document.getElementById('bairro'+idParticipante));
        inputsForm.push(document.getElementById('rua'+idParticipante));
        inputsForm.push(document.getElementById('numero'+idParticipante));

        var complementoInput = document.getElementById('complemento'+idParticipante);
        inputsForm.push(complementoInput);

        inputsForm.push(document.getElementById('instituicao['+idParticipante+']'));

        var outraInstituicaoInput = document.getElementById('outrainstituicao['+idParticipante+']');
        inputsForm.push(outraInstituicaoInput);

        inputsForm.push(document.getElementById('curso['+idParticipante+']'));

        var outroCursoInput = document.getElementById('outrocurso['+idParticipante+']');
        inputsForm.push(outroCursoInput);

        inputsForm.push(document.getElementById('turno'+idParticipante));
        inputsForm.push(document.getElementById('periodosTotal'+idParticipante));
        inputsForm.push(document.getElementById('periodo'+idParticipante));
        inputsForm.push(document.getElementById('ordem'+idParticipante));
        inputsForm.push(document.getElementById('media'+idParticipante));

        inputsForm.push(document.getElementById('anexoTermoCompromisso'+idParticipante));
        inputsForm.push(document.getElementById('anexoComprovanteMatricula'+idParticipante));
        inputsForm.push(document.getElementById('anexoCurriculoLattes'+idParticipante));
        inputsForm.push(document.getElementById('anexoAutorizacaoPais'+idParticipante));

        if(checkboxInput.checked){
            inputsForm.forEach(function(item,indice,array){
                item.setAttribute('disabled', 'disabled');
                item.removeAttribute('required');
            });
        }else if(!checkboxInput.checked){
            inputsForm.forEach(function(item,indice,array){
                item.removeAttribute('disabled');
                item.setAttribute('required', 'required');
            });

            complementoInput.removeAttribute('required');
            outraInstituicaoInput.removeAttribute('required');
            outroCursoInput.removeAttribute('required');
        }
    }

    function showInstituicao(instituicao){
        var instituicaoSelect = instituicao;
        var idSelect = instituicaoSelect.id;
        var instituicao = document.getElementById('outra'+idSelect);
        var display = document.getElementById('display'+idSelect);

        if(instituicaoSelect.value === "Outra"){        
            display.style.display = "block";
            instituicao.parentElement.style.display = '';
            instituicao.value="";
        }else if(instituicaoSelect.value === "UFAPE"){
            display.style.display = "none";
        }
    }

    function showCurso(curso){
        var cursoSelect = curso;
        var idSelect = cursoSelect.id;
        var curso = document.getElementById('outro'+idSelect);
        var displayCurso = document.getElementById('display'+idSelect);

        if(cursoSelect.value === "Outro"){        
            displayCurso.style.display = "block";
            curso.parentElement.style.display = '';
            curso.value="";
        }else{
            displayCurso.style.display = "none";
        }
    }

    function gerarPeriodo(e){
        var select = e.parentElement.parentElement.nextElementSibling;
        selectPeriodos = select.children[0].children[1];
        var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
        for(var i = 0; i < parseInt(e.value); i++) {
        html += `<option value="${i+1}">${i+1}º</option>`;
        }
        $(selectPeriodos).html('');
        $(selectPeriodos).append(html);

    }
</script>
@endsection