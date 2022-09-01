@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if (session()->has('message'))
                <br><br>
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if ($errors->any())
                <br><br>
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <form id="crearEncuestaForm" name="crearEncuestaForm" method="POST" action="{{ route('crearEncuesta') }}">
                @csrf
                <div class="row">
                    <h3>Crear encuesta</h3>
                    <div class="col-sm-12">
                        <label for="nombre_encuesta">Nombre encuesta</label>
                        <input type="text" name="nombre_encuesta" id="nombre_encuesta" class="form-control">
                    </div>
                    <div class='col-sm-4'>
                        <br>
                        <button class="btn btn-success" type="submit">Crear</button>
                    </div>
                </div>
            </form>
            <form id='crearPreguntaForm' name='crearPreguntaForm' method="POST" action="{{ route('crearPregunta') }}">
                <div class="row" id="crearPreguntas">
                    <h3>Crear preguntas</h3>
                    @csrf
                    <div class="col-sm-4">
                        <label for="id_encuesta">Seleccionar encuesta</label>
                        <select name="id_encuesta" id="id_encuesta" class="form-control">
                            @foreach ($encuestas as $encuesta)
                                <option value="{{ $encuesta->id }}">{{ $encuesta->nombre_encuesta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="nombre_pregunta">Pregunta</label>
                        <input type="text" name="nombre_pregunta" id="nombre_pregunta" class="form-control">
                        <br>
                        <button class="btn btn-success offset-md-10" type="submit">Crear</button>
                    </div>
                </div>
            </form>
            <form name='crearOpcionForm' method="POST" action="{{ route('crearOpcion') }}">
                <div class="row">
                    <h3>Crear opciones</h3>
                    @csrf
                    <div class="col-sm-4">
                        <label for="id_pregunta">Seleccionar pregunta</label>
                        <select name="id_pregunta" id="id_pregunta" class="form-control">
                            @foreach ($preguntas as $pregunta)
                                <option value="{{ $pregunta->id }}">{{ $pregunta->nombre_pregunta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="nombre_opcion">Opción</label>
                        <input type="text" name="nombre_opcion" id="nombre_opcion" class="form-control">
                        <br>
                        <button class="btn btn-success offset-md-10" type="submit">Crear</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="row">
                <h3>Ver encuesta</h3>
                <div class="col-sm-6">
                    <select name="verencuestas" id="verencuestas" class="form-control">
                        @foreach ($encuestas as $encuesta)
                            <option value="{{ $encuesta->id }}">{{ $encuesta->nombre_encuesta }}</option>
                        @endforeach
                    </select><br>
                    <button class="btn btn-primary" type="button" id="consultarEncuestas">Ver</button>
                </div>
            </div>
            <div class="row" id="visorEntrevista">

            </div>


        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("#consultarEncuestas").on('click', function() {
            var url = "{{route('verEncuestas', ':id_encuesta')}}";
            url = url.replace(':id_encuesta', $("#verencuestas").val());
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    var pregunta = '';
                    var body = '<ol type="A">';
                    response.forEach(element => {
                        if (pregunta == element.nombre_pregunta) {
                           body += '<li><input class="form-check-input" type="radio"><label class="form-check-label">'+element.nombre_opcion+'</label></li>';
                        }else{
                            pregunta = element.nombre_pregunta;
                            body += '</li></ol>';
                            body += '<li>'+element.nombre_pregunta;
                            body += '<ol type="A">';
                            body += '<li><input class="form-check-input" type="radio"><label class="form-check-label">'+element.nombre_opcion+'</label></li>';
                            
                        }
                    });
                    body += '</ol>';
                    $("#visorEntrevista").html(body);
                },
                error: function(response) {
                    console.log(response);
                },
            });
        })
    </script>
@endsection
