@extends('layouts.master')

@section('title', 'Tienda | YUSAR')

@section('meta_description', 'Catálogo de productos YUSAR - Moda para todos')

@section('content')
    <!-- Banner de tienda -->
    <div class="slider-area">
        <div class="single-slider slider-height2 d-flex align-items-center" 
             style="background-image: url('{{ asset('frontend/assets/img/hero/category.jpg') }}')">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>ACERCA DE NOSOTROS</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Área de información -->
    <div class="about-area section-padding" style="background-color: #FFF9F5;">
        <div class="container">
            <!-- Acerca de Nosotros -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="about-img">
                        <img src="{{ asset('frontend/assets/img/acerca/1.png') }}" alt="Acerca de YUSAR" class="img-fluid rounded shadow">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-caption" style="background-color: #FFEBDA; padding: 25px; border-radius: 10px;">
                        <div class="section-tittle mb-4">
                            <h2 style="color: #FF6B35;">Acerca de Nosotros</h2>
                        </div>
                        <p>Somos una empresa de diseño, moda y confección de alta costura orgullosamente boliviana. Nos apasiona el diseño y la creación de piezas que no solo reflejan la belleza y la diversidad de nuestra cultura, sino que también realzan la belleza, elegancia y el estilo de cada mujer. Desde nuestro lanzamiento, hemos trabajado con dedicación y creatividad para posicionarnos como una marca de referencia en diseño, elegancia y versatilidad dentro de la moda boliviana.</p>
                    </div>
                </div>
            </div>

            <!-- Nuestro Concepto -->
            <div class="row align-items-center mb-5" style="background-color: #E5F8FF; padding: 25px; border-radius: 10px;">
                <div class="col-lg-6 order-lg-2">
                    <div class="concept-img">
                        <img src="{{ asset('frontend/assets/img/acerca/2.png') }}" alt="Nuestro Concepto" class="img-fluid rounded shadow">
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="concept-caption">
                        <div class="section-tittle mb-4">
                            <h2 style="color: #3CAEA3;">Nuestro Concepto</h2>
                        </div>
                        <p>Nuestra marca se distingue por su esencia única. Cada una de nuestras colecciones está diseñada con un profundo sentido de equilibrio y armonía, buscando siempre resaltar la belleza, individualidad y el estilo de cada mujer. Somos la fusión perfecta entre la tradición y la modernidad, creando una moda que es tanto atemporal como contemporánea.</p>
                    </div>
                </div>
            </div>

            <!-- Secciones Adicionales -->
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="single-service text-center" style="background-color: #F2E6FF; padding: 20px; border-radius: 10px; height: 100%;">
                        <div class="service-icon">
                            <i class="fas fa-tshirt fa-3x mb-3" style="color: #8D65C5;"></i>
                        </div>
                        <h3 style="color: #8D65C5;">Nuestras Colecciones</h3>
                        <p>Nuestras colecciones se caracterizan por su sofisticación y su versatilidad, permitiendo a nuestras clientas sentirse elegantes y cómodas en cualquier ocasión. Desde piezas casuales para el día a día hasta atuendos deslumbrantes para eventos especiales. Nos inspiramos en la cultura boliviana, incorporando elementos tradicionales en diseños modernos y funcionales.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="single-service text-center" style="background-color: #FFE6E6; padding: 20px; border-radius: 10px; height: 100%;">
                        <div class="service-icon">
                            <i class="fas fa-store fa-3x mb-3" style="color: #FF6B6B;"></i>
                        </div>
                        <h3 style="color: #FF6B6B;">Nuestro Negocio</h3>
                        <p>No solo vendemos moda, sino que ofrecemos una experiencia de estilo y elegancia que empodera a las mujeres a sentirse seguras y radiantes en cualquier lugar y situación.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="single-service text-center" style="background-color: #E6FFF2; padding: 20px; border-radius: 10px; height: 100%;">
                        <div class="service-icon">
                            <i class="fas fa-tags fa-3x mb-3" style="color: #4CAF50;"></i>
                        </div>
                        <h3 style="color: #4CAF50;">Nuestros Productos</h3>
                        <p>Nuestros productos son elaborados con los mejores materiales y una atención al detalle. Estamos comprometidos con la calidad y la innovación en el diseño y la confección de alta costura en Bolivia.</p>
                    </div>
                </div>
            </div>

            <!-- Nuestros Servicios -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="services-content" style="background-color: #FFF0E6; padding: 30px; border-radius: 10px;">
                        <div class="section-tittle text-center mb-4">
                            <h2 style="color: #FF8C42;">Nuestros Servicios</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div style="background-color: #FFFFFF; padding: 20px; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                                    <h4 class="mb-3" style="color: #FF8C42;">Para mujeres que valoran la elegancia</h4>
                                    <ul class="service-list mb-4" style="list-style-type: none; padding-left: 10px;">
                                        <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: #FF8C42; margin-right: 8px;"></i><strong>Ropa casual:</strong> Prendas cómodas y elegantes para el día a día.</li>
                                        <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: #FF8C42; margin-right: 8px;"></i><strong>Ropa formal:</strong> Atuendos sofisticados para ocasiones especiales.</li>
                                        <li><i class="fas fa-check-circle" style="color: #FF8C42; margin-right: 8px;"></i><strong>Asesoría de estilo:</strong> Ayudamos a nuestras clientas a encontrar el look perfecto que realce su belleza y confianza.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div style="background-color: #FFFFFF; padding: 20px; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                                    <h4 class="mb-3" style="color: #FF8C42;">Para empresas e instituciones</h4>
                                    <ul class="service-list" style="list-style-type: none; padding-left: 10px;">
                                        <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: #FF8C42; margin-right: 8px;"></i><strong>Diseño a medida:</strong> Creaciones exclusivas adaptadas a las preferencias y necesidades de la organización.</li>
                                        <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: #FF8C42; margin-right: 8px;"></i><strong>Confección de prendas:</strong> Capacidad para fusionar elegancia y funcionalidad con un toque distintivo de la cultura de la organización.</li>
                                        <li><i class="fas fa-check-circle" style="color: #FF8C42; margin-right: 8px;"></i><strong>Patrones inclusivos:</strong> Trabajamos con todas las tallas.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection