@extends('adminlte::page')

@section('title', 'Lista de Banners')

@section('content')
<div class="card shadow-sm" style="border-top: 3px solid #1da2c1;">
    <div class="card-header" style="background: linear-gradient(135deg, #121929 0%, #123e51 100%); color: white;">
        <h3 class="card-title font-weight-bold"><i class="fas fa-images mr-2"></i>Lista de Banners</h3>
        <div class="card-tools">
            <a href="{{ route('banner.create') }}" class="btn btn-primary btn-circle" 
               style="background-color: #20dbd8; border-color: #1da2c1; width: 40px; height: 40px; border-radius: 50%;"
               data-toggle="tooltip" title="Agregar nuevo banner">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="banners-table" class="table table-bordered" style="width:100%">
                <thead style="background-color: #146a85; color: white;">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="20%">Título</th>
                        <th width="25%">Descripción</th>
                        <th width="15%">Imagen</th>
                        <th width="10%">Estado</th>
                        <th width="15%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td>{{ $banner->titulo }}</td>
                        <td>{{ Str::limit($banner->descripcion, 50) }}</td>
                        <td>
                            @if($banner->imagen)
                                <div class="img-zoom-container">
                                    <img src="{{ asset('storage/' . $banner->imagen) }}" 
                                         class="img-thumbnail img-zoom" 
                                         style="max-width: 80px; transition: transform 0.3s; border-color: #1da2c1;">
                                </div>
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>
                            @if($banner->estado)
                                <span class="badge badge-pill" style="background-color: #20dbd8; color: #121929;">Activo</span>
                            @else
                                <span class="badge badge-pill badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('banner.edit', $banner->id) }}" 
                                   class="btn btn-sm btn-warning mr-2" 
                                   style="background-color: #f39c12; border-color: #e08e0b;"
                                   data-toggle="tooltip" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('banner.destroy', $banner->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Estás seguro de eliminar este banner?')"
                                            data-toggle="tooltip" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')
<!-- DataTables CSS con HTTPS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css">
<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(32, 219, 216, 0.08);
    }
    
    .img-zoom:hover .img-zoom {
        transform: scale(1.8);
        z-index: 1000;
        position: relative;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    .btn-circle {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .badge {
        font-weight: 500;
        padding: 5px 10px;
        min-width: 70px;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .card-tools {
            margin-top: 10px;
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>
@endsection

@section('js')
<!-- DataTables JS con HTTPS -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        $('#banners-table').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            },
            "pageLength": 10,
            "responsive": true,
            "autoWidth": false,
            "dom": '<"top"f>rt<"bottom"lip><"clear">',
            "initComplete": function() {
                $('.dataTables_filter input').addClass('form-control').css('width', '250px');
            },
            "drawCallback": function() {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection