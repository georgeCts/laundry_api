@section('title', 'Bolsa de trabajo')

@section('content')
    @if(Session::has('error_message'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">{{ Session::get('error_title' )}}</h4>
                    <p>{{ Session::get('error_message' )}}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {!! Form::open(['route' => 'new-job', 'method' => 'POST', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Crear Empleo</h4>
                        <p class="card-description">Información General</p>
                        
                        <div class="form-group">
                            <label for="job">Título</label>
                            <input type="text" class="form-control" id="job" name="job" placeholder="Título del empleo" required />
                        </div>
                    
                        <div class="form-group">
                            <label for="location_id">Sucursal</label>
                            <select class="form-control form-control-sm" id="location_id" name="location_id">
                                @foreach ($lstLocations as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="requirement">Requisitos</label>
                            <textarea class="form-control" id="requirement" name="requirement" rows="5" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="offer">Ofrecemos</label>
                            <textarea class="form-control" id="offer" name="offer" rows="5" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="apply">Postularse</label>
                            <textarea class="form-control" id="apply" name="apply" rows="5" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="contact">Contacto</label>
                            <textarea class="form-control" id="contact" name="contact" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="/panel/bolsa-trabajo" role="button" class="btn btn-light">Cancelar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Imagen de la oferta laboral</h4>
                                <p class="card-description">La imagen deben ser (400 x 400)</p>
                                <div class="form-group">
                                    <label>Imágen</label>
                                    <input type="file" name="image" class="form-control" />
                                </div>

                                <hr />

                                <h4 class="card-title">Estatus</h4>
                                <p class="card-description">Selecciona el estatus que tendrá el empleo al ser creado.</p>

                                <div class="form-group">
                                    <div class="form-radio">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="status" value="PUBLISHED" checked> Publicado
                                        </label>
                                    </div>
                                    <div class="form-radio">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="status" value="DRAFT"> Borrador
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    {{--<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>--}}
    {{-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=o3myw93jxyb8rtmkdckvyptqgdkxf69orqm77h57frjjt5v0"></script> --}}
    <script>
        $(document).ready(function() {
            /* tinymce.init({
                selector: '#txtBody',
                theme: 'modern',
                height: 400,
                plugins: [
		            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		            'searchreplace wordcount visualblocks visualchars code fullscreen',
		            'insertdatetime media nonbreaking save table contextmenu directionality',
		            'emoticons template paste textcolor colorpicker textpattern imagetools'
		        ],
		        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		        toolbar2: 'print preview media | forecolor backcolor emoticons',
		        image_advtab: true
            }); */
        });
    </script>
@endsection

@include('panel.components.Navbar')
@include('panel.components.Sidebar')
@include('panel.components.Footer')
@include('panel.components.Scripts')
@include('panel.components.Stylesheets')

@extends('panel.components.Main')