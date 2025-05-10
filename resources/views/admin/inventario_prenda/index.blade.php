@extends('adminlte::page')

@section('title', 'Inventario de Prendas')

@section('content_header')
    <h1 class="d-flex justify-content-between align-items-center">
        <span><i class="fas fa-tshirt mr-2"></i>Inventario de Prendas</span>
        <button class="btn btn-success btn-sm shadow" data-toggle="modal" data-target="#modalPrendaCreate">
            <i class="fas fa-plus-circle mr-1"></i> Nueva Prenda
        </button>
    </h1>
@stop

@section('content')
    <!-- Primera Fila: CRUD Categorías y Colecciones -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-purple card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-tags mr-2"></i>Gestión de Categorías
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-tool btn-sm shadow-none" data-toggle="modal" data-target="#modalCategoriaCreate">
                            <i class="fas fa-plus-circle text-success fa-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped datatable-crud">
                            <thead>
                                <tr class="bg-lightblue">
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/'.$categoria->imagen) }}" 
                                                 alt="{{ $categoria->nombre }}" 
                                                 class="img-circle mr-2 shadow-sm" width="30">
                                            <span class="font-weight-bold">{{ $categoria->nombre }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $categoria->estado ? 'badge-success' : 'badge-danger' }}">
                                            <i class="fas {{ $categoria->estado ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                            {{ $categoria->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning shadow-sm" 
                                                data-toggle="modal" 
                                                data-target="#modalCategoriaEdit{{ $categoria->id }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-teal card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-layer-group mr-2"></i>Gestión de Colecciones
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-tool btn-sm shadow-none" data-toggle="modal" data-target="#modalColeccionCreate">
                            <i class="fas fa-plus-circle text-success fa-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped datatable-crud">
                            <thead>
                                <tr class="bg-teal">
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Fechas</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($colecciones as $coleccion)
                                <tr>
                                    <td>{{ $coleccion->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/'.$coleccion->imagen) }}" 
                                                 alt="{{ $coleccion->nombre }}" 
                                                 class="img-circle mr-2 shadow-sm" width="30">
                                            <span class="font-weight-bold">{{ $coleccion->nombre }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="d-block">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ $coleccion->fecha_inicio->format('d/m/Y') }} 
                                            <i class="fas fa-arrow-right mx-1"></i>
                                            {{ $coleccion->fecha_fin->format('d/m/Y') }}
                                        </small>
                                        @php
                                            $hoy = now();
                                            $diasRestantes = $hoy->diffInDays($coleccion->fecha_fin, false);
                                        @endphp
                                        @if($diasRestantes > 0)
                                            <span class="badge badge-info shadow-sm">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $diasRestantes }} días restantes
                                            </span>
                                        @elseif($diasRestantes == 0)
                                            <span class="badge badge-warning shadow-sm">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                Finaliza hoy
                                            </span>
                                        @else
                                            <span class="badge badge-secondary shadow-sm">
                                                <i class="fas fa-ban mr-1"></i>
                                                Finalizada
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $coleccion->estado ? 'badge-success' : 'badge-danger' }}">
                                            <i class="fas {{ $coleccion->estado ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                            {{ $coleccion->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning shadow-sm" 
                                                data-toggle="modal" 
                                                data-target="#modalColeccionEdit{{ $coleccion->id }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda Fila: Inventario de Prendas -->
    <div class="row">
        <div class="col-12">
            <div class="card card-dark card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-boxes mr-2"></i>Inventario de Prendas
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm shadow" data-toggle="modal" data-target="#modalPrendaCreate">
                            <i class="fas fa-plus-circle mr-1"></i> Nueva Prenda
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover datatable-inventario">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th> Galería</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Colección</th>
                                <th>Estado</th>
                                <th>Talla/Color</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prendas as $prenda)
                            <tr>
                                <td class="font-weight-bold">{{ $prenda->id }}</td>
                                <td>
                                    <img src="{{ $prenda->imagen_principal ? asset('storage/'.$prenda->imagen_principal) : 'https://via.placeholder.com/50?text=Sin+imagen' }}" 
                                         alt="{{ $prenda->recepcion->prenda_nombre }}" 
                                         class="img-thumbnail shadow-sm" width="50">
                                </td>
                                <td>
                                    @php
                                        // Manejo seguro de las imágenes
                                        $imagenes_sec = [];
                                        try {
                                            $imagenes_sec = is_array($prenda->imagenes_secundarias) 
                                                ? $prenda->imagenes_secundarias 
                                                : (json_decode($prenda->imagenes_secundarias ?? '[]', true) ?? []);
                                        } catch (Exception $e) {
                                            $imagenes_sec = [];
                                        }
                                    @endphp
                                
                                    @if(count($imagenes_sec) > 0)
                                        <!-- Carrusel Bootstrap -->
                                        <div id="carouselSecundario{{ $prenda->id }}" class="carousel slide" data-ride="carousel" style="max-width: 150px;">
                                            <!-- Indicadores -->
                                            @if(count($imagenes_sec) > 1)
                                                <ol class="carousel-indicators" style="bottom: -25px;">
                                                    @foreach($imagenes_sec as $key => $imagen)
                                                        <li data-target="#carouselSecundario{{ $prenda->id }}" 
                                                            data-slide-to="{{ $key }}" 
                                                            class="{{ $key == 0 ? 'active' : '' }} bg-secondary"
                                                            style="width: 8px; height: 8px; border-radius: 50%; border: none;"></li>
                                                    @endforeach
                                                </ol>
                                            @endif
                                            
                                            <!-- Imágenes -->
                                            <div class="carousel-inner rounded" style="max-height: 60px; overflow: hidden;">
                                                @foreach($imagenes_sec as $key => $imagen)
                                                    @if($imagen)
                                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('storage/'.$imagen) }}" 
                                                                 class="d-block w-100" 
                                                                 style="object-fit: cover; height: 60px;"
                                                                 alt="Imagen secundaria">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            
                                            <!-- Controles -->
                                            @if(count($imagenes_sec) > 1)
                                                <a class="carousel-control-prev" href="#carouselSecundario{{ $prenda->id }}" role="button" data-slide="prev" style="width: 20%;">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-size: 60%; filter: drop-shadow(0 0 2px rgba(0,0,0,0.5));"></span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselSecundario{{ $prenda->id }}" role="button" data-slide="next" style="width: 20%;">
                                                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-size: 60%; filter: drop-shadow(0 0 2px rgba(0,0,0,0.5));"></span>
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted"><i class="fas fa-images"></i> Sin imágenes</span>
                                    @endif
                                </td>
                                <td class="font-weight-bold">{{ $prenda->recepcion->prenda_nombre }}</td>
                                <td>
                                    @if($prenda->categoria)
                                        <span class="badge badge-pill badge-primary shadow-sm">
                                            <i class="fas fa-tag mr-1"></i>
                                            {{ $prenda->categoria->nombre }}
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-secondary shadow-sm">
                                            {{-- <i class="fas fa-question-circle mr-1"></i> --}}
                                            Sin categoría
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($prenda->coleccion)
                                        <span class="badge badge-pill badge-info shadow-sm">
                                            <i class="fas fa-layer-group mr-1"></i>
                                            {{ $prenda->coleccion->nombre }}
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-secondary shadow-sm">
                                            {{-- <i class="fas fa-question-circle mr-1"></i> --}}
                                            Sin colección
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $prenda->recepcion->estado == 'aprobado' ? 'badge-success' : 'badge-warning' }} shadow-sm">
                                        <i class="fas {{ $prenda->recepcion->estado == 'aprobado' ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                                        {{ ucfirst($prenda->recepcion->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-indigo shadow-sm">{{ $prenda->talla }}</span>
                                    <span class="badge mt-1 shadow-sm" style="background-color: {{ $prenda->color }}; color: dark;">
                                        {{ $prenda->color }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $prenda->cantidad_total > 5 ? 'bg-success' : 'bg-warning' }} shadow-sm">
                                        <i class="fas fa-boxes mr-1"></i>{{ $prenda->cantidad_total }}
                                    </span>
                                </td>
                                <td class="font-weight-bold">
                                    <span class="text-success">
                                        {{ number_format($prenda->precio_venta, 2) }} Bs.
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm shadow">
                                        <button class="btn btn-info" title="Asignar destino" data-toggle="modal" data-target="#modalPrendaDestino{{ $prenda->id }}">
                                            <i class="fas fa-project-diagram"></i>
                                        </button>
                                        <button class="btn btn-warning" title="Editar" data-toggle="modal" data-target="#modalPrendaEdit{{ $prenda->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" title="Eliminar" data-toggle="modal" data-target="#modalPrendaDelete{{ $prenda->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Todos los Modals al final -->
    @include('admin.inventario_prenda.modals.categorias.create')
    @include('admin.inventario_prenda.modals.categorias.edit')
    @include('admin.inventario_prenda.modals.colecciones.create')
    @include('admin.inventario_prenda.modals.colecciones.edit')


    @foreach($prendas as $prenda)
    @include('admin.inventario_prenda.modals.prenda.edit', [
        'prenda' => $prenda, 
        'categorias' => $categorias,
        'colecciones' => $colecciones
    ])
    @endforeach

    @foreach($prendas as $prenda)
    @include('admin.inventario_prenda.modals.prenda.destino', ['prenda' => $prenda])
    @endforeach

@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .img-circle {
            border-radius: 50%;
            object-fit: cover;
            height: 30px;
            width: 30px;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .badge {
            font-size: 0.85em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .card-outline {
            border-top: 3px solid;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }
        .card-purple.card-outline {
            border-top-color: #6f42c1;
        }
        .card-teal.card-outline {
            border-top-color: #20c997;
        }
        .card-dark.card-outline {
            border-top-color: #343a40;
        }
        .bg-lightblue {
            background-color: #3c8dbc;
            color: white;
        }
        .bg-teal {
            background-color: #20c997;
            color: white;
        }
        .datatable-inventario thead th, 
        .datatable-crud thead th {
            vertical-align: middle;
            font-weight: 600;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075) !important;
        }
        .img-thumbnail {
            transition: all 0.3s ease;
        }
        .img-thumbnail:hover {
            transform: scale(1.1);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .thead-dark th {
            background-color: #343a40;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,0.03);
        }
    </style>
@stop

@section('js')
    <!-- Toastr y DataTables CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Configuración para DataTables de CRUDs (4 registros por página)
            $('.datatable-crud').DataTable({
                responsive: true,
                pageLength: 4,
                lengthMenu: [[4, 10, 25, 50, -1], [4, 10, 25, 50, "Todos"]],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json'
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                initComplete: function() {
                    $('.dataTables_filter input').addClass('form-control-sm');
                }
            });

            // Configuración para DataTable de Inventario (7 registros por página)
            $('.datatable-inventario').DataTable({
                responsive: true,
                pageLength: 7,
                lengthMenu: [[7, 15, 30, 50, -1], [7, 15, 30, 50, "Todos"]],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json'
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                initComplete: function() {
                    $('.dataTables_filter input').addClass('form-control-sm');
                }
            });

            // Mostrar notificaciones Toastr
            @if(session('success'))
                toastr.success('{{ session('success') }}', 'Éxito', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    showMethod: 'slideDown',
                    hideMethod: 'fadeOut'
                });
            @endif

            @if($errors->any()))
                toastr.error('{{ $errors->first() }}', 'Error', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    showMethod: 'slideDown',
                    hideMethod: 'fadeOut'
                });
                @if(session('modal_target'))
                    $('{{ session('modal_target') }}').modal('show');
                @endif
            @endif

            // Vista previa de imágenes en modales
            $('input[type="file"]').change(function(e) {
                const file = e.target.files[0];
                const previewId = $(this).attr('id') + 'Preview';
                const preview = $('#' + previewId);
                const label = $(this).next('.custom-file-label');
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr('src', e.target.result).show();
                        label.text(file.name);
                    };
                    reader.readAsDataURL(file);
                } else {
                    label.text('Seleccionar archivo');
                }
            });

            // Animación para botones
            $('.btn').hover(
                function() {
                    $(this).addClass('shadow');
                },
                function() {
                    $(this).removeClass('shadow');
                }
            );

            // Debug para botones de edición
            $('[data-target^="#modalPrendaEdit"]').click(function() {
                console.log('Botón de edición clickeado');
                console.log('Modal target:', $(this).data('target'));
            });
        });
    </script>
@stop