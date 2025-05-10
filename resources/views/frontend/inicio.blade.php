<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Inicio | YUSAR</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/favicon.ico') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/progressbar_barfiller.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/animated-headline.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>
<body class="full-wrapper">
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset ('frontend/assets/img/logo/carga.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start-->
    <header>
        
        <!-- Header Start -->
        <div class="header-area ">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="menu-wrapper d-flex align-items-center justify-content-between">
                        <div class="header-left d-flex align-items-center">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="/"><img src="{{ asset ('frontend/assets/img/logo/logo0.png') }}" alt="" style="width: 150px; height: 140px ; "></a>
                            </div>
                            <!-- Main-menu -->
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="/">Inicio</a></li> 
                                        <li><a href="/frontend/tienda">Tienda</a></li>
                                        <li><a href="/frontend/acerca">Acerca de Nosotros</a></li>
                                        <li><a href="frontend.blog">Mas</a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">Blog</a></li>
                                                <li><a href="blog_details.html">Eventos</a></li>
                                                <li><a href="/frontend/tryon">TryOn</a></li>
                                                <li><a href= "login">Inicio adm.</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contact.html">Contactanos</a></li>
                                    </ul>
                                </nav>
                            </div>   
                        </div>
                        <div class="header-right1 d-flex align-items-center">
                            <!-- Social -->
                            <div class="header-social d-none d-md-block">
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-tiktok"></i></a> 
                                <!-- <a href="/frontend/login" class="user-login"><i class="fas fa-user"></i></a> -->
                                <a href="{{ Auth::guard('cliente')->check() ? route('cliente.inicio') : route('cliente.login') }}" 
                                class="user-login"
                                title="{{ Auth::guard('cliente')->check() ? 'Mi cuenta' : 'Iniciar sesión' }}">
                                    <i class="fas fa-user"></i>
                                    @if(Auth::guard('cliente')->check())
                                        <span class="d-none d-sm-inline"></span>
                                    @else
                                        <span class="d-none d-sm-inline"></span>
                                    @endif
                                </a>
                            </div>
                            <!-- Search Box -->
                            <div class="search d-none d-md-block">
                                <ul class="d-flex align-items-center">
                                    <li class="mr-15">
                                        <div class="nav-search search-switch">
                                            <i class="ti-search"></i>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="card-stor">
                                            <img src="{{ asset('frontend/assets/img/gallery/card.svg') }}" alt="">
                                            <span>0</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <!-- header end -->
    <main>
        <!--? Hero Area Start-->
        <div class="container-fluid">
            <div class="slider-area">
                <!-- Mobile Device Show Menu-->
                <div class="header-right2 d-flex align-items-center">
                    <!-- Social -->
                    <div class="header-social  d-block d-md-none">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                    <!-- Search Box -->
                    <div class="search d-block d-md-none" >
                        <ul class="d-flex align-items-center">
                            <li class="mr-15">
                                <div class="nav-search search-switch">
                                    <i class="ti-search"></i>
                                </div>
                            </li>
                            <li>
                                <div class="card-stor">
                                    <img src="{{ asset('frontend/assets/img/gallery/card.svg') }}" alt="">
                                    <span>0</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /End mobile  Menu-->


                <style>
    .single-slider {
        position: relative;
        overflow: hidden;
    }

    .banner-image {
        width: 100%;
        height: 600px; /* Ajusta según tu diseño */
        object-fit: cover; /* Recorta la imagen manteniendo el aspecto */
    }

    .hero__caption {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: #fff;
        background: rgba(0, 0, 0, 0.5); /* Fondo semitransparente para resaltar el texto */
        padding: 20px;
        border-radius: 10px;
        width: 80%;
    }

    /* .banner-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    } */

    .banner-description {
        font-size: 1.2rem;
    }

    /* Estilos adicionales para mejorar el formato del texto en el banner */
    .banner-description p {
        margin-bottom: 10px;
    }

    .banner-description strong {
        font-weight: bold;
    }

    .banner-description em, .banner-description i {
        font-style: italic;
    }

    .banner-description ul, .banner-description ol {
        text-align: left;
        margin-left: 20px;
    }
</style>

<!-- <div class="slider-active dot-style">
    @if(isset($banners) && $banners->count() > 0)
        @foreach($banners as $banner)
        <div class="single-slider position-relative">
            <img src="{{ asset('storage/' . $banner->imagen) }}" alt="{{ $banner->titulo }}" class="img-fluid w-100 banner-image">
            <div class="hero__caption text-center">
                 <h1 class="banner-title">{{ $banner->titulo }}</h1> 
                <div class="banner-description">{!! $banner->descripcion !!}</div>
            </div>
        </div>
        @endforeach
    @else
        <div class="alert alert-info">No hay banners disponibles.</div>
    @endif
</div> -->
<div class="slider-active dot-style">
    @if(isset($banners) && $banners->count() > 0)
        @foreach($banners as $banner)
        <div class="single-slider position-relative">
            <img src="{{ asset('storage/' . $banner->imagen) }}" alt="{{ $banner->titulo }}" class="img-fluid w-100 banner-image">
            <div class="hero__caption text-center">
                <div class="banner-description">{!! $banner->descripcion !!}</div>
            </div>
        </div>
        @endforeach
    @else
        <div class="alert alert-info">No hay banners disponibles.</div>
    @endif
</div>

                
            </div>
        </div>
        <!-- End Hero -->
        <!--? Popular Items Start -->
        <div class="popular-items pt-50">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-popular-items mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                            <div class="popular-img">
                                <img src="{{ asset ('frontend/assets/img/yusar/5.jpg') }}" alt="">
                                <div class="img-cap">
                                    <span>Blusas</span>
                                </div>
                                <div class="favorit-items">
                                 <a href="shop.html" class="btn">Comprar ahora</a>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-popular-items mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                     <div class="popular-img">
                            <img src="{{ asset('frontend/assets/img/yusar/2.jpg') }}" alt="">
                            <div class="img-cap">
                                <span>Abrigos</span>
                            </div>
                            <div class="favorit-items">
                             <a href="shop.html" class="btn">Comprar ahora</a>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-popular-items mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="popular-img">
                        <img src="{{ asset('frontend/assets/img/yusar/3.jpg') }}" alt="">
                        <div class="img-cap">
                            <span>Pantalones</span>
                        </div>
                        <div class="favorit-items">
                         <a href="shop.html" class="btn">Comprar ahora</a>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="single-popular-items mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                <div class="popular-img">
                    <img src="{{ asset('frontend/assets/img/yusar/4.jpg') }}" alt="">
                    <div class="img-cap">
                        <span>Rompevientos</span>
                    </div>
                    <div class="favorit-items">
                     <a href="shop.html" class="btn">Comprar ahora</a>
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>
</div>
<!-- Popular Items End -->
<!--? New Arrival Start -->
<div class="new-arrival">
    <div class="container">
        <!-- Section tittle -->
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                <div class="section-tittle mb-60 text-center wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
                    <h2>Nuevos<br>Productos</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                    <div class="popular-img">
                        <img src="{{ asset('frontend/assets/img/yusar/6.jpg') }}" alt="">
                        <div class="favorit-items">
                            <!-- <span class="flaticon-heart"></span> -->
                            <img src="{{ asset('frontend/assets/img/gallery/favorit-card.png') }}" alt="">
                        </div>
                    </div>
                    <div class="popular-caption">
                        <h3><a href="product_details.html">Abrigo Manga Cero</a></h3>
                        <div class="rating mb-10">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span>300 Bs</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                    <div class="popular-img">
                        <img src="{{ asset('frontend/assets/img/yusar/7.jpg') }}" alt="">
                        <div class="favorit-items">
                            <!-- <span class="flaticon-heart"></span> -->
                            <img src="{{ asset('frontend/assets/img/gallery/favorit-card.png') }}" alt="">
                        </div>
                    </div>
                    <div class="popular-caption">
                     <h3><a href="product_details.html">Blusa Floreada</a></h3>
                     <div class="rating mb-10">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span>300 Bs</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                <div class="popular-img">
                    <img src="{{ asset('frontend/assets/img/yusar/8.jpg') }}" alt="">
                    <div class="favorit-items">
                        <!-- <span class="flaticon-heart"></span> -->
                        <img src="{{ asset('frontend/assets/img/gallery/favorit-card.png') }}" alt="">
                    </div>
                </div>
                <div class="popular-caption">
                 <h3><a href="product_details.html">Blusa Floreada</a></h3>
                 <div class="rating mb-10">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <span>300 Bs</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
        <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
            <div class="popular-img">
                <img src="{{ asset('frontend/assets/img/yusar/10.jpg') }}" alt="">
                <div class="favorit-items">
                    <!-- <span class="flaticon-heart"></span> -->
                    <img src="{{ asset('frontend/assets/img/gallery/favorit-card.png') }}" alt="">
                </div>
            </div>
            <div class="popular-caption">
             <h3><a href="product_details.html">Blusa Floreada</a></h3>
             <div class="rating mb-10">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <span>280 Bs</span>
        </div>
    </div>
</div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
    <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
        <div class="popular-img">
            <img src="{{ asset('frontend/assets/img/yusar/9.jpg') }}" alt="">
            <div class="favorit-items">
                <!-- <span class="flaticon-heart"></span> -->
                <img src="{{ asset('frontend/assets/img/gallery/favorit-card.png') }}" alt="">
            </div>
        </div>
        <div class="popular-caption">
         <h3><a href="product_details.html">Blusa Floreada</a></h3>
         <div class="rating mb-10">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <span>300 Bs</span>
    </div>
</div>
</div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
    <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
        <div class="popular-img">
            <img src="{{ asset('frontend/assets/img/yusar/11.jpg') }}" alt="">
            <div class="favorit-items">
                <!-- <span class="flaticon-heart"></span> -->
                <img src="{{ asset('frontend/assets/img/gallery/favorit-card.png') }}" alt="">
            </div>
        </div>
        <div class="popular-caption">
         <h3><a href="product_details.html">Kimono Vestido</a></h3>
         <div class="rating mb-10">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <span>350 Bs</span>
    </div>
</div>
</div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
    <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">
        <div class="popular-img">
            <img src="{{ asset('frontend/assets/img/yusar/12.jpg') }}" alt="">
            <div class="favorit-items">
                <!-- <span class="flaticon-heart"></span> -->
                <img src="{{ asset('frontend/assets/img/gallery/favorit-card.png') }}" alt="">
            </div>
        </div>
        <div class="popular-caption">
         <h3><a href="product_details.html">Kimono Vestido</a></h3>
         <div class="rating mb-10">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <span>300 Bs</span>
    </div>
</div>
</div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
    <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".8s">
        <div class="popular-img">
            <img src="{{ asset('frontend/assets/img/yusar/1.jpg') }}" alt="">
            <div class="favorit-items">
                <!-- <span class="flaticon-heart"></span> -->
                <img src="{{ asset('frontend/assets/img/gallery/favorit-card.png') }}" alt="">
            </div>
        </div>
        <div class="popular-caption">
         <h3><a href="product_details.html">Blusa</a></h3>
         <div class="rating mb-10">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <span>300 Bs</span>
    </div>
</div>
</div>
</div>
<!-- Button -->
<div class="row justify-content-center">
    <div class="room-btn">
        <a href="catagori.html" class="border-btn">Buscar mas</a>
    </div>
</div>
</div>
</div>
<!--? New Arrival End -->
<!--? collection -->
<section class="collection section-bg2 section-padding30 section-over1 ml-15 mr-15" data-background="{{ asset('frontend/assets/img/yusar/100.jpg') }}">
    <div class="container-fluid"></div>
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9">
            <div class="single-question text-center">
                <h2 class="wow fadeInUp" data-wow-duration="2s" data-wow-delay=".1s">Ve la nueva coleccion que tenemos para ti!</h2>
                <a href="about.html" class="btn class="wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">Ver mas</a>
            </div>
        </div>
    </div>
</div>
</section>
<!-- End collection -->
<!--? Popular Locations Start 01-->
<div class="popular-product pt-50">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="single-product mb-50">
                    <div class="location-img">
                        <img src="assets/img/gallery/popular-imtes1.png" alt="">
                    </div>
                    <div class="location-details">
                        <p><a href="product_details.html">Te perderas esta<br> nueva coleccion?</a></p>
                        <a href="product_details.html" class="btn">Leer Mas</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="single-product mb-50">
                    <div class="location-img">
                        <img src="assets/img/gallery/popular-imtes2.png" alt="">
                    </div>
                    <div class="location-details">
                        <p><a href="product_details.html">Quieres ver mas?<br> Mira nuestras colecciones anteriores</a></p>
                        <a href="product_details.html" class="btn">Leer Mas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Popular Locations End -->
<!--? Services Area Start -->
<div class="categories-area section-padding40 gray-bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-cat mb-50 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                    <div class="cat-icon">
                        <img src="{{ asset('frontend/assets/img/icon/services1.svg') }}" alt="">
                    </div>
                    <div class="cat-cap">
                        <h5>Incluye envios!</h5>
                        <p>Disponible para toda Bolivia!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-cat mb-50 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                    <div class="cat-icon">
                        <img src="{{ asset('frontend/assets/img/icon/services2.svg') }}" alt="">
                    </div>
                    <div class="cat-cap">
                        <h5>Pagos Seguro</h5>
                        <p>Puedes cancelar con tu tarjeta!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-cat mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="cat-icon">
                        <img src="{{ asset('frontend/assets/img/icon/services3.svg') }}" alt="">
                    </div>
                    <div class="cat-cap">
                        <h5>Reembolso</h5>
                        <p>No estas satisfecho con tu producto? Te hacemos la devolucion antes de las 48 hrs.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-cat wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                    <div class="cat-icon">
                        <img src="{{ asset('frontend/assets/img/icon/services4.svg') }}" alt="">
                    </div>
                    <div class="cat-cap">
                        <h5>Soporte 24/7</h5>
                        <p>Si tienes alguna duda no olvides contactarte con nosotros.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--? Services Area End -->


<!-- Sección del Mapa -->
<!-- Sección del Mapa -->
<section class="map-section">
        <div class="map-container">
            <h2 class="map-title">Nuestra Sucursal</h2>
            <!-- Contenedor del mapa -->
            <div id="map"></div>
        </div>
    </section>

    <script>
        function initMap() {
            // Coordenadas de La Paz, Bolivia
            const initialCoords = { lat: -16.4897, lng: -68.1193 };

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: initialCoords,
                styles: [
                    {
                        featureType: "all",
                        elementType: "labels.text.fill",
                        stylers: [{ color: "#ffffff" }] // Color del texto en el mapa
                    },
                    {
                        featureType: "all",
                        elementType: "labels.text.stroke",
                        stylers: [{ color: "#000000" }, { visibility: "on" }] // Borde del texto en el mapa
                    },
                    {
                        featureType: "landscape",
                        elementType: "geometry",
                        stylers: [{ color: "#1a1a1a" }] // Color del fondo del mapa
                    },
                    {
                        featureType: "poi",
                        elementType: "geometry",
                        stylers: [{ color: "#000000" }] // Color de puntos de interés
                    },
                    {
                        featureType: "road",
                        elementType: "geometry",
                        stylers: [{ color: "#2d2d2d" }] // Color de las carreteras
                    },
                    {
                        featureType: "water",
                        elementType: "geometry",
                        stylers: [{ color: "#000000" }] // Color del agua
                    }
                ]
            });

            const sucursales = @json($sucursales ?? []); // Si $sucursales no está definida, usar un array vacío

            sucursales.forEach(sucursal => {
                if (sucursal.latitud && sucursal.longitud) {
                    const marker = new google.maps.Marker({
                        position: { lat: parseFloat(sucursal.latitud), lng: parseFloat(sucursal.longitud) },
                        map: map,
                        title: sucursal.nombre,
                        icon: {
                            url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png", // Icono personalizado para los marcadores
                            scaledSize: new google.maps.Size(40, 40) // Tamaño del icono
                        }
                    });

                    const infoWindow = new google.maps.InfoWindow({
                        content: `<div style="color: #000; font-size: 14px; padding: 10px;">
                                    <strong>${sucursal.nombre}</strong><br>${sucursal.direccion}
                                </div>`,
                    });

                    // Efecto de hover en los marcadores
                    marker.addListener("mouseover", () => {
                        infoWindow.open(map, marker);
                    });

                    marker.addListener("mouseout", () => {
                        infoWindow.close();
                    });
                }
            });
        }
    </script>

    <!-- Cargar Google Maps API de manera asíncrona -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao&libraries=places&callback=initMap">
    </script>


<style>
        /* Estilos generales */
        

        .map-section {
            background-color: #000;
            padding: 80px 0;
        }

        .map-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .map-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 40px;
            color: #fff;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Estilos para los marcadores */
        .gm-style .gm-style-iw {
            color: #000;
            font-size: 14px;
            font-weight: 500;
        }

        .gm-style .gm-style-iw a {
            color: #007bff;
            text-decoration: none;
        }

        .gm-style .gm-style-iw a:hover {
            text-decoration: underline;
        }
    </style>
<br><br>


</main>
<footer>
    <!-- Footer Start-->
    <div class="footer-area footer-padding">
        <div class="container-fluid ">
            <div class="row d-flex justify-content-between">
                <div class="col-xl-3 col-lg-3 col-md-8 col-sm-8">
                 <div class="single-footer-caption mb-50">
                   <div class="single-footer-caption mb-30">
                      <!-- logo -->
                      <div class="footer-logo mb-35">
                       <a href="index.html"><img src="{{ asset('frontend/assets/img/logo/logo2_footer.png') }}" alt=""></a>
                   </div>
                   <div class="footer-tittle">
                       <div class="footer-pera">
                           <p>Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                       </div>
                   </div>
                   <!-- social -->
                   <div class="footer-social">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4">
        <div class="single-footer-caption mb-50">
            <div class="footer-tittle">
                <h4>Quick links</h4>
                <ul>
                    <li><a href="#">Image Licensin</a></li>
                    <li><a href="#">Style Guide</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4">
        <div class="single-footer-caption mb-50">
            <div class="footer-tittle">
                <h4>Shop Category</h4>
                <ul>
                    <li><a href="#">Image Licensin</a></li>
                    <li><a href="#">Style Guide</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4">
        <div class="single-footer-caption mb-50">
            <div class="footer-tittle">
                <h4>Pertners</h4>
                <ul>
                    <li><a href="#">Image Licensin</a></li>
                    <li><a href="#">Style Guide</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4">
        <div class="single-footer-caption mb-50">
            <div class="footer-tittle">
                <h4>Contactos</h4>
                <ul>
                    <li><a href="#">+591 65115396</a></li>
                    <li><a href="#">+591 71576695</a></li>
                    <li><a href="#">yusarmoda246@gmail.com</a></li>
                    <li><a href="#">Shopping Norte, planta baja. local 102</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- footer-bottom area -->
<div class="footer-bottom-area">
    <div class="container">
        <div class="footer-border">
           <div class="row d-flex align-items-center">
               <div class="col-xl-12 ">
                   <div class="footer-copy-right text-center">
                       <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                          Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos los derechos reservados | Desarrollado <i aria-hidden="true"></i> por <a href="/" target="_blank">Gabriel Herrera</a>
                          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Footer End-->
</footer>
<!--? Search model Begin -->
<div class="search-model-box">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-btn">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Searching key.....">
        </form>
    </div>
</div>
<!-- Search model end -->
<!-- Scroll Up -->
<div id="back-top" >
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
</div>

<!-- JS here -->
<!-- Jquery, Popper, Bootstrap -->
<script src="{{ asset ('frontend/assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/popper.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/bootstrap.min.js') }}"></script>

<!-- Slick-slider , Owl-Carousel ,slick-nav -->
<script src="{{ asset ('frontend/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/slick.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/jquery.slicknav.min.js') }}"></script>

<!-- One Page, Animated-HeadLin, Date Picker -->
<script src="{{ asset ('frontend/assets/js/wow.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/animated.headline.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/gijgo.min.js') }}"></script>

<!-- Nice-select, sticky,Progress -->
<script src="{{ asset ('frontend/assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/jquery.sticky.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/jquery.barfiller.js') }}"></script>

<!-- counter , waypoint,Hover Direction -->
<script src="{{ asset ('frontend/assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/hover-direction-snake.min.js') }}"></script>

<!-- contact js -->
<script src="{{ asset ('frontend/assets/js/contact.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/jquery.form.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/mail-script.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/jquery.ajaxchimp.min.js') }}"></script>

<!-- Jquery Plugins, main Jquery -->	
<script src="{{ asset ('frontend/assets/js/plugins.js') }}"></script>
<script src="{{ asset ('frontend/assets/js/main.js') }}"></script>

</body>
</html>