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
                                        <li><a href="frontend.acerca">Acerca de Nosotros</a></li>
                                        <li><a href="frontend.blog">Blog</a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">Blog</a></li>
                                                <li><a href="blog_details.html">Blog</a></li>
                                                <li><a href="elements.html">Colecciones</a></li>
                                                <li><a href= "login">Login YUSAR</a></li>
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
   

    <!-- Contenido Principal del Cliente -->
    <main class="client-area ">
        <div class="container py-5">
            <!-- Tarjeta de Bienvenida -->
            <div class="client-welcome-card mb-5">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        @if(Auth::guard('cliente')->user()->foto)
                            <img src="{{ asset('storage/' . Auth::guard('cliente')->user()->foto) }}" 
                                 alt="Foto de perfil" 
                                 class="client-avatar img-fluid rounded-circle">
                        @else
                            <div class="client-avatar default-avatar rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h2 class="client-greeting">¡Hola, {{ Auth::guard('cliente')->user()->nombre }}!</h2>
                        <p class="client-email mb-0">{{ Auth::guard('cliente')->user()->correo }}</p>
                        <p class="client-member-since">Miembro desde: {{ Auth::guard('cliente')->user()->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-4 text-md-right">
                        <form action="{{ route('cliente.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sección de Acciones Rápidas -->
            <div class="row mb-5">
                <div class="col-md-4 mb-4">
                    <a href="#" class="client-quick-action">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                            <div class="card-body text-center">
                                <div class="action-icon mb-3">
                                    <i class="fas fa-shopping-bag fa-2x"></i>
                                </div>
                                <h5 class="action-title">Mis Compras</h5>
                                <p class="action-description small text-muted">Revisa el estado de tus pedidos</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="#" class="client-quick-action">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                            <div class="card-body text-center">
                                <div class="action-icon mb-3">
                                    <i class="fas fa-heart fa-2x"></i>
                                </div>
                                <h5 class="action-title">Favoritos</h5>
                                <p class="action-description small text-muted">Tus productos guardados</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="#" class="client-quick-action">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                            <div class="card-body text-center">
                                <div class="action-icon mb-3">
                                    <i class="fas fa-user-edit fa-2x"></i>
                                </div>
                                <h5 class="action-title">Mi Perfil</h5>
                                <p class="action-description small text-muted">Actualiza tu información</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Últimos Pedidos -->
            <div class="client-orders mb-5">
                <div class="section-header d-flex justify-content-between align-items-center mb-4">
                    <h3 class="section-title">Tus últimos pedidos</h3>
                    <a href="#" class="btn btn-link">Ver historial completo</a>
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#12345</td>
                                        <td>15/07/2023</td>
                                        <td>200 Bs</td>
                                        <td><span class="badge badge-success">Entregado</span></td>
                                        <td class="text-right">
                                            <a href="#" class="btn btn-sm btn-outline-primary">Detalles</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#12344</td>
                                        <td>10/07/2023</td>
                                        <td>200 Bs</td>
                                        <td><span class="badge badge-warning">En camino</span></td>
                                        <td class="text-right">
                                            <a href="#" class="btn btn-sm btn-outline-primary">Detalles</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos Recomendados -->
            <div class="client-recommendations">
                <div class="section-header mb-4">
                    <h3 class="section-title">Productos que te pueden gustar</h3>
                </div>
                
                <div class="row">
                    <!-- Producto 1 -->
                    <div class="col-md-3 col-6 mb-4">
                        <div class="product-card">
                            <div class="product-thumb">
                                <a href="#">
                                    <img src="https://via.placeholder.com/300x300" alt="Producto" class="img-fluid">
                                </a>
                            </div>
                            <div class="product-details">
                                <h4 class="product-title"><a href="#">Zapatos Deportivos</a></h4>
                                <div class="product-price">200 Bs</div>
                                <div class="product-actions mt-2">
                                    <button class="btn btn-sm btn-outline-secondary btn-block">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Producto 2 -->
                    <div class="col-md-3 col-6 mb-4">
                        <div class="product-card">
                            <div class="product-thumb">
                                <a href="#">
                                    <img src="https://via.placeholder.com/300x300" alt="Producto" class="img-fluid">
                                </a>
                            </div>
                            <div class="product-details">
                                <h4 class="product-title"><a href="#">Camiseta Casual</a></h4>
                                <div class="product-price">$200 Bs</div>
                                <div class="product-actions mt-2">
                                    <button class="btn btn-sm btn-outline-secondary btn-block">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Producto 3 -->
                    <div class="col-md-3 col-6 mb-4">
                        <div class="product-card">
                            <div class="product-thumb">
                                <a href="#">
                                    <img src="https://via.placeholder.com/300x300" alt="Producto" class="img-fluid">
                                </a>
                            </div>
                            <div class="product-details">
                                <h4 class="product-title"><a href="#">Pantalón Moderno</a></h4>
                                <div class="product-price">200 Bs</div>
                                <div class="product-actions mt-2">
                                    <button class="btn btn-sm btn-outline-secondary btn-block">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Producto 4 -->
                    <div class="col-md-3 col-6 mb-4">
                        <div class="product-card">
                            <div class="product-thumb">
                                <a href="#">
                                    <img src="https://via.placeholder.com/300x300" alt="Producto" class="img-fluid">
                                </a>
                            </div>
                            <div class="product-details">
                                <h4 class="product-title"><a href="#">Reloj Elegante</a></h4>
                                <div class="product-price">200 Bs</div>
                                <div class="product-actions mt-2">
                                    <button class="btn btn-sm btn-outline-secondary btn-block">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>




    <style>
        .client-area {
            background-color: #f8f9fa;
            min-height: calc(100vh - 150px);
        }
        
        .client-welcome-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .client-avatar {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 3px solid #f1f1f1;
        }
        
        .default-avatar {
            background-color: #e9ecef;
            color: #6c757d;
        }
        
        .client-greeting {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .client-email {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .client-member-since {
            color: #adb5bd;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }
        
        .client-quick-action .card {
            transition: all 0.3s ease;
        }
        
        .client-quick-action:hover .card {
            transform: translateY(-5px);
        }
        
        .action-icon {
            color: #4f46e5;
        }
        
        .action-title {
            color: #333;
            font-weight: 600;
        }
        
        .section-title {
            font-weight: 600;
            color: #333;
            position: relative;
            padding-bottom: 10px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: #4f46e5;
        }
        
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .product-thumb {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
        }
        
        .product-details {
            padding: 15px;
        }
        
        .product-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .product-title a {
            color: #333;
            text-decoration: none;
        }
        
        .product-price {
            font-weight: 600;
            color: #4f46e5;
        }
        
        .hover-shadow {
            transition: box-shadow 0.3s ease;
        }
        
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        
        .transition {
            transition: all 0.3s ease;
        }
    </style>



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