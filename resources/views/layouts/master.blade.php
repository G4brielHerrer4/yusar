<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'YUSAR')</title>
    <meta name="description" content="@yield('meta_description', '')">
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
    @yield('styles')
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

    <!-- Main Content -->
    <main>
        @yield('content')
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
                               <p>Somos YUSAR una empresa dediacada a la confeccion boliviana con prendas muy elegantes y profesioanles.</p>
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
                    <h4>Categorias</h4>
                    <ul>
                        <li><a href="#">Blusas</a></li>
                        <li><a href="#">Pantalones</a></li>
                        <li><a href="#">Camisas</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4">
            <div class="single-footer-caption mb-50">
                <div class="footer-tittle">
                    <h4>Servicios</h4>
                    <ul>
                        <li><a href="#">Confecciones Personalizadas</a></li>
                        <li><a href="#">Compras por mayor</a></li>
                        <li><a href="#">Arreglos</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4">
            <div class="single-footer-caption mb-50">
                <div class="footer-tittle">
                    <h4>Mas</h4>
                    <ul>
                        <li><a href="#">Politica y Privacidad</a></li>
                        <li><a href="#">Uso de cookies</a></li>
                        <li><a href="#">Como funciona los pagos?</a></li>
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
    
    @yield('scripts')
</body>
</html>