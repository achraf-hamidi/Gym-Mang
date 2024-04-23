<template>
    <div class="homepage-5">
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
                        <img style="width: 200px;" class="navbar-brand-regular" src="landing_assets/img/logo/logo-white.png" alt="brand-logo">
                        <img style="width: 200px;" class="navbar-brand-sticky" src="landing_assets/img/logo/logo.png" alt="sticky brand-logo">
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
                                    <a class="nav-link" target="_blank" href="https://club.teknosolvo.com/login">Démo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link scroll" href="#tarifs">Tarif ss</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link scroll" href="#contact">Contact</a>
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
                                    <a target="_blank" href="https://club.teknosolvo.com/login" class="btn prolend-primary style-three text-uppercase">Démonstration gratuit</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Shape Bottom -->
                <div class="shape-bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1920 170">
                        <defs>
                            <linearGradient x1="49.253%" y1="85.804%" x2="49.253%" y2="43.074%" id="a">
                                <stop stop-color="#FFF" offset="0%" />
                                <stop stop-color="#FFF" offset="100%" />
                            </linearGradient>
                        </defs>
                        <g fill="none">
                            <path d="M1920 4.719v69.5c-362.63 60.036-692.797 55.536-990.5-13.5C565.833-23.615 256 12.813 0 170L1 4.719h1919z" fill="url(#a)" transform="rotate(180 960.5 87.36)" />
                            <path d="M1 170V99c269.033-70.44 603.533-66.44 1003.5 12C1494 207 1921 4.719 1921 4.719L1920 170H1z" fill-opacity=".3" fill="#FFF" />
                            <path d="M1 170.75V99C373.115 4.216 705.281-4.951 997.5 71.5c365.667 95.667 673.5 73.406 923.5-66.781l-1 166.031H1z" fill-opacity=".3" fill="#FFF" />
                            <path d="M1 170v-67C400.333-1.333 744.167-19 1032.5 50c432.5 103.5 754 19.219 888.5-45.281l-1 166.031L1 170z" fill-opacity=".35" fill="#FFF" />
                        </g>
                    </svg>
                </div>
            </section> 
            <footer class="footer-area dark-bg">
                <div class="footer-top ptb_50">
                    <div class="container">
                        <div class="row  d-flex flex-wrap justify-content-center justify-content-sm-between  py-4">
                            <div class="logo-footer col-12 col-sm-6 col-lg-3">
                                <div class="footer-items">
                                    <a class="scroll d-flex justify-content-center align-items-center navbar-brand" href="#accueil">
                                        <img style="width: 218px;" class="logo" src="landing_assets/img/logo/favicon32.png" alt="TeknoSolvo, TeknoClub, Agence de création de site internet, application web et mobile."><br>
                                    </a>
                                    <div class="social-icons d-flex flex-wrap justify-content-center justify-content-sm-between ">
                                        <a target="_blank" class="facebook" href="https://www.facebook.com/TeknoClub">
                                            <i class="fab fa-facebook-f"></i>
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a target="_blank" class="instagram" href="https://instagram.com/TeknoClub">
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
    </div>
</template>
