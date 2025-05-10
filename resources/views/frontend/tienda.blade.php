@extends('layouts.master')

@section('title', 'Tienda | YUSAR')

@section('meta_description', 'Catálogo completo de productos YUSAR - Moda boliviana de alta costura para mujeres')

@section('content')
    <!-- Banner de tienda -->
    <div class="slider-area">
        <div class="single-slider slider-height2 d-flex align-items-center" 
             style="background-image: url('{{ asset('frontend/assets/img/hero/category.jpg') }}')">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Nuestra Tienda</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Sección de Categorías -->
    <section class="category-section py-5">
        <div class="container">
            <div class="section-title text-center mb-4" style="color: #FF6B35;">
                <h3>Explora por Categorías</h3>
                <div class="divider mx-auto my-2" style="width: 80px; height: 3px; background-color: #FF6B35;"></div>
            </div>
            <div class="row g-4">
                @foreach($categorias as $categoria)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <!-- Frente: Imagen -->
                            <div class="flip-card-front">
                                <div class="category-card position-relative">
                                    <img src="{{ asset('storage/'.$categoria->imagen) }}" 
                                         alt="{{ $categoria->nombre }}" 
                                         class="img-fluid category-img"
                                         onerror="this.onerror=null;this.src='{{ asset('img/placeholder-category.jpg') }}'">
                                    <div class="category-overlay">
                                        <h5>{{ $categoria->nombre }}</h5>
                                        <span class="badge bg-white text-secondary">
                                            {{ $categoria->prendas_count }} productos
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Reverso: Descripción -->
                            <div class="flip-card-back bg-white text-dark">
                                <div class="p-3">
                                    <h5>{{ $categoria->nombre }}</h5>
                                    <p class="small">{{ $categoria->descripcion ?? 'Descripción no disponible' }}</p>
                                    <a href="{{ route('frontend.tienda', ['categoria' => $categoria->id]) }}" 
                                       class="btn btn-sm" style="background-color: #FF6B35; color: white;">
                                        Ver productos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sección de Colecciones (Opcional) -->
    {{-- @if($colecciones && $colecciones->count() > 0)
    <section class="collection-section py-5" style="background-color: #E5F8FF;">
        <div class="container">
            <div class="section-title text-center mb-4" style="color: #3CAEA3;">
                <h3>Nuestras Colecciones</h3>
                <div class="divider mx-auto my-2" style="width: 80px; height: 3px; background-color: #3CAEA3;"></div>
            </div>
            <div class="row g-4">
                @foreach($colecciones as $coleccion)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="collection-card card h-100 border-0 shadow-sm hover-effect">
                        @if($coleccion->imagen_portada)
                        <img src="{{ asset('storage/'.$coleccion->imagen_portada) }}" 
                             class="card-img-top collection-img" 
                             alt="{{ $coleccion->nombre }}"
                             style="height: 200px; object-fit: cover;">
                        @else
                        <div class="collection-placeholder bg-secondary d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-images fa-3x text-white"></i>
                        </div>
                        @endif
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $coleccion->nombre }}</h5>
                            <p class="small text-muted">
                                {{ $coleccion->fecha_inicio->format('M Y') }} - {{ $coleccion->fecha_fin->format('M Y') }}
                            </p>
                            <a href="{{ route('frontend.tienda', ['coleccion' => $coleccion->id]) }}" 
                               class="btn btn-sm" style="background-color: #3CAEA3; color: white;">
                                Ver colección
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif --}}

    <!-- Sección de Productos -->
    <section class="product-section py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="section-title" style="color: #8D65C5;">
                    <h3>Productos Destacados</h3>
                    <div class="divider my-2" style="width: 60px; height: 3px; background-color: #8D65C5;"></div>
                </div>
                <form class="d-inline-block">
                    <select name="order" class="form-select" onchange="this.form.submit()">
                        <option value="newest" {{ request('order') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                        <option value="price_asc" {{ request('order') == 'price_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                        <option value="price_desc" {{ request('order') == 'price_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                        <option value="popular" {{ request('order') == 'popular' ? 'selected' : '' }}>Más populares</option>
                    </select>
                    @if(request('categoria'))
                        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    @endif
                    @if(request('coleccion'))
                        <input type="hidden" name="coleccion" value="{{ request('coleccion') }}">
                    @endif
                    @if(request('buscar'))
                        <input type="hidden" name="buscar" value="{{ request('buscar') }}">
                    @endif
                </form>
            </div>
            
            <div class="row g-4">
                @forelse($prendas as $prenda)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card card h-100 border-0 shadow-sm product-hover">
                        <div class="position-relative product-img-container">
                            <a href="{{ route('frontend.tienda', ['id' => $prenda->id]) }}">
                                <img src="{{ asset($prenda->imagen_principal) }}" 
                                     class="card-img-top product-img" 
                                     alt="{{ $prenda->prenda->nombre }}"
                                     style="height: 250px; object-fit: cover;">
                            </a>
                            
                            <!-- Etiquetas -->
                            <div class="product-badges">
                                @if(isset($prenda->es_nuevo) && $prenda->es_nuevo)
                                    <span class="badge bg-success position-absolute top-0 start-0 m-2">
                                        Nuevo
                                    </span>
                                @endif
                                
                                @if(isset($prenda->descuento) && $prenda->descuento > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2 {{ isset($prenda->es_nuevo) && $prenda->es_nuevo ? 'mt-4' : '' }}">
                                        -{{ $prenda->descuento }}%
                                    </span>
                                @endif
                                
                                @if($prenda->stock <= 5 && $prenda->stock > 0)
                                    <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                                        Últimas {{ $prenda->stock }}
                                    </span>
                                @elseif($prenda->stock == 0)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                        Agotado
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Botones de acción rápida -->
                            <div class="product-actions position-absolute w-100 text-center" 
                                 style="bottom: 10px; opacity: 0; transition: all 0.3s;">
                                <button class="btn btn-sm btn-light mx-1 add-to-wishlist" 
                                        data-product-id="{{ $prenda->id }}" 
                                        title="Agregar a favoritos">
                                    <i class="fas fa-heart"></i>
                                </button>
                                
                                <button class="btn btn-sm btn-light mx-1 quick-view" 
                                        data-product-id="{{ $prenda->id }}" 
                                        title="Vista rápida">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                @if($prenda->stock > 0)
                                <button class="btn btn-sm btn-primary mx-1 add-to-cart" 
                                        data-product-id="{{ $prenda->id }}" 
                                        title="Añadir al carrito">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <a href="{{ route('frontend.tienda', ['id' => $prenda->id]) }}" class="text-decoration-none">
                                <h5 class="card-title text-dark">{{ $prenda->prenda->nombre }}</h5>
                            </a>
                            <p class="text-muted small mb-2">
                                {{ $prenda->prenda->categoria->nombre }}
                                @if(isset($prenda->prenda->coleccion) && $prenda->prenda->coleccion)
                                | <span class="fst-italic">{{ $prenda->prenda->coleccion->nombre }}</span>
                                @endif
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if(isset($prenda->precio_anterior) && $prenda->precio_anterior > $prenda->precio)
                                        <span class="text-decoration-line-through text-muted me-2">
                                            ${{ number_format($prenda->precio_anterior, 2) }}
                                        </span>
                                    @endif
                                    <span class="h5" style="color: #FF6B6B;">${{ number_format($prenda->precio, 2) }}</span>
                                </div>
                                
                                <div class="product-rating">
                                    @php
                                        $rating = isset($prenda->rating) ? $prenda->rating : 0;
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5;
                                    @endphp
                                    
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $fullStars)
                                            <i class="fas fa-star text-warning"></i>
                                        @elseif($i == $fullStars + 1 && $halfStar)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No se encontraron productos con los filtros seleccionados.
                        <a href="{{ route('frontend.tienda') }}" class="btn btn-link">Ver todos los productos</a>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-5">
                {{ $prendas->appends(request()->query())->links() }}
            </div>
        </div>
    </section>

    <!-- Modal Vista Rápida -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vista Rápida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="quickViewContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Efecto hover para productos
    document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('.product-hover');
        
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const actions = this.querySelector('.product-actions');
                if (actions) {
                    actions.style.opacity = '1';
                    actions.style.bottom = '20px';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                const actions = this.querySelector('.product-actions');
                if (actions) {
                    actions.style.opacity = '0';
                    actions.style.bottom = '10px';
                }
            });
        });
        
        // Vista rápida
        const quickViewButtons = document.querySelectorAll('.quick-view');
        quickViewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const modal = document.getElementById('quickViewModal');
                const contentDiv = document.getElementById('quickViewContent');
                
                // Mostrar spinner de carga
                contentDiv.innerHTML = `
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                `;
                
                // Mostrar modal
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
                
                // Cargar datos del producto (implementar la ruta adecuada)
                fetch(`/producto-rapido/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            contentDiv.innerHTML = data.html;
                            
                            // Inicializar funcionalidades adicionales si es necesario
                            initQuickViewFunctions();
                        } else {
                            contentDiv.innerHTML = `
                                <div class="alert alert-danger">
                                    No se pudo cargar la información del producto.
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        contentDiv.innerHTML = `
                            <div class="alert alert-danger">
                                Error al cargar la información: ${error.message}
                            </div>
                        `;
                    });
            });
        });
        
        // Agregar al carrito
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                
                // Animación de agregar al carrito
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;
                
                // Llamada AJAX para agregar al carrito (implementar)
                setTimeout(() => {
                    // Simular respuesta exitosa
                    this.innerHTML = '<i class="fas fa-check"></i>';
                    
                    // Actualizar contador del carrito (implementar)
                    updateCartCounter();
                    
                    // Restaurar botón después de un tiempo
                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-shopping-cart"></i>';
                        this.disabled = false;
                    }, 1500);
                }, 800);
            });
        });
        
        // Función para actualizar contador del carrito
        function updateCartCounter() {
            // Implementar lógica para actualizar contador del carrito
        }
        
        // Función para inicializar funcionalidades en la vista rápida
        function initQuickViewFunctions() {
            // Implementar si es necesario
        }
    });
</script>
@endsection

@section('styles')
<style>
    /* Estilos para las tarjetas flip de categorías */
    .flip-card {
        perspective: 1000px;
        height: 300px;
        cursor: pointer;
    }
    
    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1);
    }
    
    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }
    
    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .flip-card-front {
        color: black;
    }
    
    .flip-card-back {
        transform: rotateY(180deg);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .category-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        padding: 10px;
        color: white;
    }
    
    /* Estilos para productos */
    .product-img-container {
        overflow: hidden;
    }
    
    .product-hover {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .product-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1) !important;
    }
    
    .product-img {
        transition: transform 0.5s;
    }
    
    .product-hover:hover .product-img {
        transform: scale(1.05);
    }
    
    /* Estilos para colecciones */
    .hover-effect {
        transition: transform 0.3s;
    }
    
    .hover-effect:hover {
        transform: translateY(-5px);
    }
    
    /* Estilos para los botones */
    .btn-primary {
        background-color: #FF6B35;
        border-color: #FF6B35;
    }
    
    .btn-primary:hover, .btn-primary:focus {
        background-color: #E85A2A;
        border-color: #E85A2A;
    }
    
    .btn-outline-primary {
        color: #FF6B35;
        border-color: #FF6B35;
    }
    
    .btn-outline-primary:hover, .btn-outline-primary:focus {
        background-color: #FF6B35;
        border-color: #FF6B35;
    }
    
    /* Estilos para paginación */
    .pagination .page-item.active .page-link {
        background-color: #FF6B35;
        border-color: #FF6B35;
    }
    
    .pagination .page-link {
        color: #FF6B35;
    }
    
    /* Estilos adicionales */
    .divider {
        display: block;
    }
</style>
@endsection