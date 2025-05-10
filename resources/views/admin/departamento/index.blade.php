@extends('adminlte::page')

@section('title', 'Lista de Departamentos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #121929 0%, #123e51 100%); padding: 1rem; border-radius: 8px;">
        <h1 class="m-0 text-white"><i class="fas fa-building mr-2"></i>Lista de Departamentos</h1>
    </div>
@stop

@section('content')
    <div class="card shadow-sm" style="border-top: 3px solid #1da2c1;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa;">
            <h3 class="card-title m-0"></h3>
            <a href="{{ route('departamento.create') }}" class="btn btn-circle" 
               style="background-color: #20dbd8; border-color: #1da2c1; width: 40px; height: 40px;"
               data-toggle="tooltip" title="Crear nuevo departamento">
                <i class="fas fa-plus text-white"></i>
            </a>
        </div>
        <div class="card-body">
            <table id="departamentos-table" class="table table-hover" style="width:100%">
                <thead style="background-color: #146a85; color: white;">
                    <tr>
                        <th width="10%">ID</th>
                        <th>Nombre</th>
                        <th width="15%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departamentos as $departamento)
                    <tr>
                        <td>{{ $departamento->id }}</td>
                        <td>{{ $departamento->nombre }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('departamento.edit', $departamento->id) }}" 
                                   class="btn btn-sm btn-circle btn-warning mr-2"
                                   style="width: 32px; height: 32px;"
                                   data-toggle="tooltip" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('departamento.destroy', $departamento->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-circle btn-danger"
                                            style="width: 32px; height: 32px;"
                                            onclick="return confirm('¿Estás seguro de eliminar este departamento?')"
                                            data-toggle="tooltip" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
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
@stop

@section('css')
<!-- DataTables CSS con HTTPS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css">
<style>
    .card {
        border-radius: 8px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(32, 219, 216, 0.05);
    }
    
    .btn-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .btn-circle:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-warning {
        background-color: #f39c12;
        border-color: #e08e0b;
    }
    
    .btn-danger {
        background-color: #e74c3c;
        border-color: #c0392b;
    }
    
    .card-header {
        padding: 0.75rem 1.25rem;
    }
    
    @media (max-width: 576px) {
        #departamentos-table th, 
        #departamentos-table td {
            padding: 8px 5px;
        }
        
        .btn-sm {
            width: 28px !important;
            height: 28px !important;
            padding: 0;
        }
    }
</style>
@stop

@section('js')
<!-- DataTables JS con HTTPS -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#departamentos-table').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            },
            "pageLength": 10,
            "responsive": true,
            "autoWidth": false,
            "dom": '<"top"f>rt<"bottom"lip><"clear">',
            "initComplete": function() {
                $('.dataTables_filter input').addClass('form-control').css({
                    'width': '100%',
                    'max-width': '300px',
                    'margin-bottom': '10px'
                });
            }
        });
        
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@stop