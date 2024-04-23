<!doctype html>
<html class="no-js" lang="en">

<head> 
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CLUBI  facilement votre club</title>
    <meta name="keywords" content="CLUBI, Logiciel gestion club de sport, club, gestion des adhérents, gestion de paiaments" />
    <meta name="author" content="teknosolvo.com" />
    <link rel="icon" type="image/png" href="{{ asset('/assets/img/logo/favicon.png')}}">
    <link rel="canonical" href="{{ URL::current() }}" />
    <meta property="url" content="{{ URL::current() }}" />
    <meta property="type" content="article, website" />
    <meta property="title" content="CLUBI - Logiciel gestion club de sport - Gérez facilement votre club" />
    <meta property="description" content="CLUBI, Une solution de gestion complète de votre club" />
    <meta property="image" content="{{ asset('/assets/img/logo/share.png')}}" />
    <meta property="og:url" content="{{ URL::current() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="CLUBI - Logiciel gestion club de sport - Gérez facilement votre club" />
    <meta property="og:description" content="CLUBI, Une solution de gestion complète de votre club" />
    <meta property="og:image" content="{{ asset('/assets/img/logo/share.png')}}" />
    <meta property="og:site_name" content="TeknoSolvo" />
    <meta property="og:image:alt" content="TeknoSolvo, CLUBI - Logiciel gestion club de sport - Gérez facilement votre club" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <link rel="stylesheet" href="{{ asset('/landing_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('/landing_assets/css/responsive.css')}}">
    <style type="text/css">
    .backg {
        background: rgba(0, 0, 0, 0) url("{{ asset('/landing_assets/img/bg/download-bg.jpg')}}") no-repeat fixed center center / cover;
    }

    .facebook {
        background: linear-gradient(45deg, #5e82ce, #3b5999) !important;
    }

    .instagram {
        background: linear-gradient(45deg, #ffbf36, #ff6028) !important;
    }

    .whatsapp {
        background: linear-gradient(45deg, #45d013, #32a42e) !important;
    }

    .phone {
        background: linear-gradient(45deg, #9799fb, #608fff) !important;
    }
    </style>
</head>

<body class="homepage-5">
    <!--====== Preloader Area Start ======-->
    <div class="preloader-main">
        <div class="preloader-wapper">
            <svg class="preloader" xmlns="http://www.w3.org/2000/svg" version="1.1" width="600" height="200">
                <defs>
                    <filter id="goo" x="-40%" y="-40%" height="200%" width="400%">
                        <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -8" result="goo" />
                    </filter>
                </defs>
                <g filter="url(#goo)">
                    <circle class="dot" cx="50" cy="50" r="25" fill="#ff6028" />
                    <circle class="dot" cx="50" cy="50" r="25" fill="#ff6028" />
                </g>
            </svg>
            <div>
                <div class="loader-section section-left"></div>
                <div class="loader-section section-right"></div>
            </div>
        </div>
    </div>
    <!--====== Scroll To Top Area Start ======-->
    <div id="scrollUp" title="Scroll To Top">
        <i class="fas fa-arrow-up"></i>
    </div>
    <!--====== Scroll To Top Area End ======-->
    <div class="main">
        <!-- ***** Header Start ***** -->
        <header class="navbar navbar-sticky navbar-expand-lg navbar-dark">
            <div class="container position-relative">
                <a class="navbar-brand" href="index.html">
                    <img style="width: 200px;" class="navbar-brand-regular" src="{{ asset('/landing_assets/img/logo/logo-white.png')}}" alt="brand-logo">
                    <img style="width: 200px;" class="navbar-brand-sticky" src="{{ asset('/landing_assets/img/logo/logo.png')}}" alt="sticky brand-logo">
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="navbarToggler" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-inner">
                    <!--  Mobile Menu Toggler -->
                    <button class="navbar-toggler d-lg-none" type="button" data-toggle="navbarToggler" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <nav>
                        <ul class="navbar-nav" id="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="{{route('login')}}">Démo</a>
                            </li> 
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <!-- ***** Header End ***** -->
        <!-- ***** Welcome Area Start ***** -->
        <section id="home" class="section welcome-area bg-overlay h-100vh overflow-hidden">
            <div class="container h-100">
                <div class="row justify-content-center align-items-center h-100">
                    <!-- Welcome Intro Start -->
                    <div class="col-12 col-lg-7">
                        <div class="welcome-intro">
                            <h1 class="text-white"><span class="fw-3">Une solution de gestion</span> complète de votre club</h1>
                            <p class="text-white my-4">Nous vous aidons à gagner du temps dans la gestion de vos adhérents. </p>
                            <!-- Store Buttons -->
                            <div class="button-group store-buttons d-flex">
                                <a target="_blank" href="{{route('login')}}" class="btn prolend-primary style-three text-uppercase">Démonstration gratuit</a>
                            </div>
                        </div>
                    </div> 
                </div>
            </div> 
        <!--====== Footer Area Start ======-->
        <footer class="footer-area dark-bg">
            <div class="footer-top ptb_50">
                <div class="container">
                    <div class="row  d-flex flex-wrap justify-content-center justify-content-sm-between  py-4">
                        <div class="logo-footer col-12 col-sm-6 col-lg-3">
                            <div class="footer-items">
                                <a class="scroll d-flex justify-content-center align-items-center navbar-brand" href="#accueil">
                                    <img style="width: 218px;" class="logo" src="{{ asset('/landing_assets/img/logo/favicon32.png')}}" alt="TeknoSolvo, CLUBI, Agence de création de site internet, application web et mobile."><br>
                                </a>
                                <div class="social-icons d-flex flex-wrap justify-content-center justify-content-sm-between ">
                                    <a target="_blank" class="facebook" href="https://www.facebook.com/CLUBI">
                                        <i class="fab fa-facebook-f"></i>
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a target="_blank" class="instagram" href="https://instagram.com/CLUBI">
                                        <i class="fab fa-instagram"></i>
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a target="_blank" class="whatsapp" href="https://wa.me/212619845673">
                                        <i class="fab fa-whatsapp"></i>
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a class="phone" href="tel:+212619845673">
                                        <i class="fab fa fa-phone"></i>
                                        <i class="fab fa fa-phone"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="menu-footer col-12 col-sm-6 col-lg-3">
                            <div class="footer-items ">
                                <h3 class="footer-title mb-2">Fonctionnalités</h3>
                                <ul>
                                    <li class="py-2 justify-content-center"><a class="scroll" href="#adhrents">Gestion des adhérents</a></li>
                                    <li class="py-2 justify-content-center"><a class="scroll" href="#abonnements">Gestion des abonnements</a></li>
                                    <li class="py-2 justify-content-center"><a class="scroll" href="#paiements">Gestion des paiements</a></li>
                                    <li class="py-2 justify-content-center"><a class="scroll" href="#utilisateurs">Gestion des utilisateurs</a></li>
                                    <li class="py-2 justify-content-center"><a class="scroll" href="#presences">Gestion de présences</a></li>
                                    <li class="py-2 justify-content-center"><a class="scroll" href="#statistiques">Statistiques</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="question col-12 col-sm-6 col-lg-3">
                            <div class="footer-items">
                                <h3 class="footer-title mb-2">Si vous avez des questions rejoignez-nous sur :</h3>
                                <ul>
                                    <li class="py-2">
                                        <a class="media justify-content-center align-items-center d-flex " href="javaScript:void(0)">
                                            <div class="social-icon mr-3">
                                                <i class="fas  fa-map-marker"></i>
                                            </div>
                                            <span class="media-body align-self-center">El Jadida, Maroc</span>
                                        </a>
                                    </li>
                                    <li class="py-2">
                                        <a class="media justify-content-center align-items-center d-flex " href="mailto:contact@teknosolvo.com">
                                            <div class="social-icon mr-3">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <span class="media-body align-self-center">contact@teknosolvo.com</span>
                                        </a>
                                    </li>
                                    <li class="py-2">
                                        <a class="media justify-content-center align-items-center d-flex " href="tel:+212619845673<">
                                            <div class="social-icon mr-3">
                                                <i class="fas fa-phone-alt"></i>
                                            </div>
                                            <span class="media-body align-self-center">+212 619 84 56 73</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--====== Footer Area End ======-->
    </div>
    <!-- ***** All jQuery Plugins ***** -->
    <!-- jQuery(necessary for all JavaScript plugins) -->
    <script src="{{ asset('/landing_assets/js/jquery/jquery-3.3.1.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('/landing_assets/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{ asset('/landing_assets/js/bootstrap/bootstrap.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('/landing_assets/js/plugins/plugins.min.js')}}"></script>
    <!-- Active js -->
    <script src="{{ asset('/landing_assets/js/active.js')}}"></script>
</body>

</html>