@extends('adminlte::page')

@section('title', 'Lista de Sucursales')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #121929 0%, #123e51 100%); padding: 1rem; border-radius: 8px;">
        <h1 class="m-0 text-white"><i class="fas fa-store-alt mr-2"></i>Lista de Sucursales</h1>
    </div>
@stop

@section('content')
    <div class="card shadow-sm" style="border-top: 3px solid #1da2c1;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa;">
            <h3 class="card-title m-0"></h3>
            <a href="{{ route('sucursal.create') }}" class="btn btn-circle" 
               style="background-color: #20dbd8; border-color: #1da2c1; width: 40px; height: 40px;"
               data-toggle="tooltip" title="Crear nueva sucursal">
                <i class="fas fa-plus text-white"></i>
            </a>
        </div>
        <div class="card-body p-0">
            <table id="sucursales-table" class="table table-bordered" style="width:100%">
                <thead style="background-color: #146a85; color: white;">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Nombre</th>
                        <th width="20%">Dirección</th>
                        <th width="10%">Latitud</th>
                        <th width="10%">Longitud</th>
                        <th width="15%">Departamento</th>
                        <th width="10%">Estado</th>
                        <th width="15%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sucursales as $sucursal)
                    <tr>
                        <td>{{ $sucursal->id }}</td>
                        <td>{{ $sucursal->nombre }}</td>
                        <td>{{ $sucursal->direccion }}</td>
                        <td>{{ $sucursal->latitud ?? 'Sin Latitud' }}</td>
                        <td>{{ $sucursal->longitud ?? 'Sin Longitud' }}</td>
                        <td>{{ optional($sucursal->departamento)->nombre ?? 'Sin Departamento' }}</td>
                        <td>
                            <span class="badge badge-pill {{ $sucursal->estado ? 'badge-success' : 'badge-danger' }}"
                                  style="background-color: {{ $sucursal->estado ? '#20dbd8' : '#e74c3c' }}; min-width: 70px;">
                                {{ $sucursal->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('sucursal.edit', $sucursal->id) }}" 
                                   class="btn btn-sm btn-circle btn-warning mr-2"
                                   style="width: 32px; height: 32px;"
                                   data-toggle="tooltip" title="Editar sucursal">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-circle btn-danger"
                                        style="width: 32px; height: 32px;"
                                        onclick="confirmarEliminacion({{ $sucursal->id }})"
                                        data-toggle="tooltip" title="Eliminar sucursal">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form id="form-eliminar-{{ $sucursal->id }}" action="{{ route('sucursal.destroy', $sucursal->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
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
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
    
    .badge {
        font-weight: 500;
        padding: 5px 10px;
    }
    
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .btn-circle {
            margin-top: 10px;
        }
        
        #sucursales-table {
            font-size: 0.85rem;
        }
        
        #sucursales-table th, 
        #sucursales-table td {
            padding: 8px 5px;
        }
    }
</style>
@stop

@section('js')
<!-- DataTables JS con HTTPS -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#sucursales-table').DataTable({
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
            },
            "drawCallback": function() {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        
        $('[data-toggle="tooltip"]').tooltip();
    });

    function confirmarEliminacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#146a85',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            buttonsStyling: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-eliminar-' + id).submit();
            }
        });
    }
</script>
@stop