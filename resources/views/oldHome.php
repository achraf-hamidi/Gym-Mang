<!doctype html>
<html class="no-js" lang="en">

<head> 
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TeknoClub - Logiciel gestion club de sport - Gérez facilement votre club</title>
    <meta name="keywords" content="TeknoClub, Logiciel gestion club de sport, club, gestion des adhérents, gestion de paiaments" />
    <meta name="author" content="teknosolvo.com" />
    <link rel="icon" type="image/png" href="{{ asset('/assets/img/logo/favicon.png')}}">
    <link rel="canonical" href="{{ URL::current() }}" />
    <meta property="url" content="{{ URL::current() }}" />
    <meta property="type" content="article, website" />
    <meta property="title" content="TeknoClub - Logiciel gestion club de sport - Gérez facilement votre club" />
    <meta property="description" content="TeknoClub, Une solution de gestion complète de votre club" />
    <meta property="image" content="{{ asset('/assets/img/logo/share.png')}}" />
    <meta property="og:url" content="{{ URL::current() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="TeknoClub - Logiciel gestion club de sport - Gérez facilement votre club" />
    <meta property="og:description" content="TeknoClub, Une solution de gestion complète de votre club" />
    <meta property="og:image" content="{{ asset('/assets/img/logo/share.png')}}" />
    <meta property="og:site_name" content="TeknoSolvo" />
    <meta property="og:image:alt" content="TeknoSolvo, TeknoClub - Logiciel gestion club de sport - Gérez facilement votre club" />
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
                            <li class="nav-item">
                                <a class="nav-link scroll" href="#tarifs">Tarifs</a>
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
                                <a target="_blank" href="{{route('login')}}" class="btn prolend-primary style-three text-uppercase">Démonstration gratuit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-5">
                        <!-- Contact Box -->
                        <div class="contact-box bg-white text-center rounded p-4 p-sm-5 mt-5 mt-lg-0 shadow-lg">
                            <!-- Contact Form -->
                            <form id="contact-form">
                                <div class="contact-top">
                                    <h3 class="contact-title">Demande de devis gratuit</h3><br>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Nom Complet *" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email *" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="phone" placeholder="Téléphone *" required="required">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" style="width:100%">
                                                <optgroup label="Type d'abonnement *">
                                                    <option>Mensuel</option>
                                                    <option>Trimestriel</option>
                                                    <option>Semestriel</option>
                                                    <option>Annuel</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-bordered w-100 mt-3 mt-sm-4"><span class="text-white pr-3"><i class="fas fa-paper-plane"></i></span>Envoyer</button>
                                    </div>
                                </div>
                            </form>
                            <p class="form-message"></p>
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
        <!-- ***** Welcome Area End ***** -->
        <section id="features" class="section product-features-area overflow-hidden ptb_100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-7">
                        <!-- Section Heading -->
                        <div class="section-heading text-center">
                            <h2 class="text-capitalize">Dirigez votre club de sport</h2>
                            <p class="d-none d-sm-block mt-4">Notre logiciel de gestion s'adapte aux spécificités de votre structure sportive</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Icon Box -->
                        <div class="icon-box text-center p-3">
                            <!-- Featured Icon -->
                            <div class="featured-icon mb-3">
                                <span class="flaticon-tap"></span>
                            </div>
                            <!-- Icon Text -->
                            <div class="icon-text">
                                <h3 class="mb-2">Gestion des adhérents</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Icon Box -->
                        <div class="icon-box text-center p-3">
                            <!-- Featured Icon -->
                            <div class="featured-icon mb-3">
                                <span class="flaticon-fingerprint"></span>
                            </div>
                            <!-- Icon Text -->
                            <div class="icon-text">
                                <h3 class="mb-2">Gestion des abonnements</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Icon Box -->
                        <div class="icon-box text-center p-3">
                            <!-- Featured Icon -->
                            <div class="featured-icon mb-3">
                                <span class="flaticon-chat"></span>
                            </div>
                            <!-- Icon Text -->
                            <div class="icon-text">
                                <h3 class="mb-2">Gestion des paiements</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Icon Box -->
                        <div class="icon-box text-center p-3">
                            <!-- Featured Icon -->
                            <div class="featured-icon mb-3">
                                <span class="flaticon-notification"></span>
                            </div>
                            <!-- Icon Text -->
                            <div class="icon-text">
                                <h3 class="mb-2">Gestion de présences</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Icon Box -->
                        <div class="icon-box text-center p-3">
                            <!-- Featured Icon -->
                            <div class="featured-icon mb-3">
                                <span class="flaticon-wifi"></span>
                            </div>
                            <!-- Icon Text -->
                            <div class="icon-text">
                                <h3 class="mb-2">Gestion des utilisateurs</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Icon Box -->
                        <div class="icon-box text-center p-3">
                            <!-- Featured Icon -->
                            <div class="featured-icon mb-3">
                                <span class="flaticon-app"></span>
                            </div>
                            <!-- Icon Text -->
                            <div class="icon-text">
                                <h3 class="mb-2">Statistiques</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ***** Service Area Start ***** -->
        <section id="adhrents" class="section service-area overflow-hidden ptb_100 bg-gray">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-6">
                        <!-- Service Text -->
                        <div class="service-text pt-4 pt-lg-0">
                            <h2 class="promo-text mb-4">Gestion des adhérents</h2>
                            <p class="pt-3">Gérez vos adhésions en ligne et gagnez du temps.
                                Avec TeknoClub, vous centralisez dans votre espace d’administration toutes les informations importantes sur vos adhérents (Liste des adhérents, badges des adhérents, Profile adhérent contient les bloc suivant (coordonnées adhérent, Abonnement actuel et historiques, Historiques de présences, paiaments, recharge de compte, Parrinages, Nombre de visites, Net à payer, Montant payé, montant retourner au cas de changement le type de pack ou abonnement, et le reste a payer ), modifier un adhérent, supprimer un adhérent, et ajouter un adhérent, etc.....)</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- Service Thumb -->
                        <div class="service-thumb mx-auto text-center pt-4 pt-lg-0">
                            <img src="{{ asset('/landing_assets/img/01.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ***** Service Area End ***** -->
        <!-- ***** Discover Area Start ***** -->
        <section id="abonnements" class="section discover-area overflow-hidden ptb_100">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-6 order-2 order-lg-1">
                        <!-- Discover Thumb -->
                        <div class="service-thumb discover-thumb mx-auto text-center pt-4 pt-lg-0">
                            <img src="{{ asset('/landing_assets/img/02.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 order-1 order-lg-2">
                        <!-- Discover Text -->
                        <div class="discover-text pt-4 pt-lg-0">
                            <h2 class="promo-text mb-4">Gestion des abonnements</h2>
                            <p class="pt-3">Gérez vos abonnements avec une manier trés simple.
                                Avec TeknoClub, Tu a le droit de consulter la liste des abonnées en cours ou expiré ansi que une page contient la liste des adhérent qui est bloqué leur abonnement, et aussi vous pouvez consulter les statistiques des abonnements par une périod d'années de votre choix.
                                Page d'absences : Permettant de gérer les absences d'adhérents avec une déclaration avant la date d'absence, cet etaps la ......,
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="paiements" class="section service-area bg-gray overflow-hidden ptb_100">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-6">
                        <!-- Service Text -->
                        <div class="service-text pt-4 pt-lg-0">
                            <h2 class="promo-text mb-4">Gestion des paiements</h2>
                            <ul class="service-list">
                                <!-- Single Service -->
                                <li class="single-service media py-2">
                                    <div class="feature-icon text-primary align-self-center pr-4">
                                        <span><i class="fas fa-check-circle fa-2x"></i></span>
                                    </div>
                                    <div class="service-text media-body">
                                        <p>Les impayés et retards de paiement représentent un problème récurrent.
                                            pour recouvrer les sommes en minimisant au maximum la perte de temps consacré à cette tâche, une stratégie efficace de gestion des impayés s’impose. Pour vous aider, voici en bref notre guide pour gérer ses impayés avec une manier trés facile.</p>
                                    </div>
                                </li>
                                <!-- Single Service -->
                                <li class="single-service media py-2">
                                    <div class="feature-icon text-primary align-self-center pr-4">
                                        <span><i class="fas fa-check-circle fa-2x"></i></span>
                                    </div>
                                    <div class="service-text media-body">
                                        <p>Historiques de réglements : Sur cette page, vous trouverez tous les paiements qui ont été effectués avec des détails trés important pour vous, par exemple ( Total net à payer, Montant total a payé, montant total retourner ou cas de changement de type d'abonnement ou pack, et le Total reste a payer, aussi vous trouvez les détails de paiaments pour chaque abonnement d'un adhérent), ansi que il a une bloc de rechereche par adhérent et une date du au pour facilité la manier de recherche.</p>
                                    </div>
                                </li>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- Service Thumb -->
                        <div class="service-thumb mx-auto text-center pt-4 pt-lg-0">
                            <img src="{{ asset('/landing_assets/img/03.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ***** Service Area End ***** -->
        <!-- ***** Discover Area Start ***** -->
        <section id="utilisateurs" class="section discover-area   overflow-hidden ptb_100">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-6 order-2 order-lg-1">
                        <!-- Discover Thumb -->
                        <div class="service-thumb discover-thumb mx-auto text-center pt-4 pt-lg-0">
                            <img src="{{ asset('/landing_assets/img/04.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 order-1 order-lg-2">
                        <!-- Discover Text -->
                        <div class="discover-text pt-4 pt-lg-0">
                            <h2 class="promo-text mb-4">Gestion des utilisateurs</h2>
                            <p class="pt-3">Assignez des rôles pré-établis aux utilisateurs pour organiser qui à accès à vos informations les plus cruciales.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ***** Discover Area End ***** -->
        <section id="statistiques" class="section service-area bg-gray overflow-hidden ptb_100">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-6">
                        <!-- Service Text -->
                        <div class="service-text pt-4 pt-lg-0">
                            <h2 class="promo-text mb-4">Statistiques</h2>
                            <ul class="service-list">
                                <!-- Single Service -->
                                <li class="single-service media py-2">
                                    <div class="feature-icon text-primary align-self-center pr-4">
                                        <span><i class="fas fa-check-circle fa-2x"></i></span>
                                    </div>
                                    <div class="service-text media-body">
                                        <p>Les impayés et retards de paiement représentent un problème récurrent.
                                            pour recouvrer les sommes en minimisant au maximum la perte de temps consacré à cette tâche, une stratégie efficace de gestion des impayés s’impose. Pour vous aider, voici en bref notre guide pour gérer ses impayés avec une manier trés facile.</p>
                                    </div>
                                </li>
                                <!-- Single Service -->
                                <li class="single-service media py-2">
                                    <div class="feature-icon text-primary align-self-center pr-4">
                                        <span><i class="fas fa-check-circle fa-2x"></i></span>
                                    </div>
                                    <div class="service-text media-body">
                                        <p>Historiques de réglements : Sur cette page, vous trouverez tous les paiements qui ont été effectués avec des détails trés important pour vous, par exemple ( Total net à payer, Montant total a payé, montant total retourner ou cas de changement de type d'abonnement ou pack, et le Total reste a payer, aussi vous trouvez les détails de paiaments pour chaque abonnement d'un adhérent), ansi que il a une bloc de rechereche par adhérent et une date du au pour facilité la manier de recherche.</p>
                                    </div>
                                </li>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- Service Thumb -->
                        <div class="service-thumb mx-auto text-center pt-4 pt-lg-0">
                            <img src="{{ asset('/landing_assets/img/05.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ***** Service Area End ***** -->
        <!-- ***** Discover Area Start ***** -->
        <section id="presences" class="section discover-area   overflow-hidden ptb_100">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-6 order-2 order-lg-1">
                        <!-- Discover Thumb -->
                        <div class="service-thumb discover-thumb mx-auto text-center pt-4 pt-lg-0">
                            <img src="{{ asset('/landing_assets/img/06.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 order-1 order-lg-2">
                        <!-- Discover Text -->
                        <div class="discover-text pt-4 pt-lg-0">
                            <h2 class="promo-text mb-4">Gestion de présences</h2>
                            <p class="pt-3">Simple et efficace, les joueurs peuvent facilement informer leurs présences en quelques clics!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="tarifs" class="comparison-area bg-gray ptb_100 overflow-scroll">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-9">
                        <!-- Section Heading -->
                        <div class="section-heading text-center">
                            <h2 class="text-capitalize">Les packs de TeknoClub</h2>
                            <p class="d-none d-sm-block mt-4">Nos offres s'adaptent à tout type de club
                                Pendant 15 jours, bénéficiez gratuitement de toutes les fonctionnalités payantes de TeknoClub, pour votre club. Vous pourrez ensuite choisir l’offre la plus adaptée.</p>
                            <p class="d-block d-sm-none mt-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum obcaecati.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-responsive-lg table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="h3 text-primary" scope="col"></th>
                                    <th class="text-primary text-center" scope="col">
                                        <div class="card-body product-body">
                                            <h3 class="pb-2"> Forfait régulier Mensuel </h3>
                                        </div>
                                    </th>
                                    <th class="text-primary text-center" scope="col">
                                        <div class="card-body product-body">
                                            <h3 class="pb-2">Forfait régulier Trimestriel</h3>
                                        </div>
                                    </th>
                                    <th class="text-primary text-center" scope="col">
                                        <div class="card-body product-body">
                                            <h3 class="pb-2">Forfait régulier Semestriel</h3>
                                        </div>
                                    </th>
                                    <th class="text-primary text-center" scope="col">
                                        <div class="card-body product-body">
                                            <h3 class="pb-2">Forfait régulier Annuel</h3>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="h3 text-primary" scope="col"> </th>
                                    <th class="h3 text-primary text-center" scope="col">449.00 MAD</th>
                                    <th class="h3 text-primary text-center" scope="col">1199.00 MAD</th>
                                    <th class="h3 text-primary text-center" scope="col">2399.00 MAD</th>
                                    <th class="h3 text-primary text-center" scope="col">4999.00 MAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" title="Base des adhérents, Historique des adhérents, Pré-inscription, Suivi statistiques des adhérents...">Gestion des adhérents</th>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" title="Abonnement en cours, Abonnement expiré, Se désabonner, Liste d'abonnements au moins 15 jours avant la date fin...">Gestion des abonnements</th>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" title="Les impayés, Historiques de réglements, Recharges...">Gestion des paiements</th>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" title="Simple et efficace, les joueurs peuvent facilement informer leurs présences en quelques clics!...">Gestion des présences</th>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" title="Les rôles de projet vous permettent d'assigner des rôles à différents utilisateurs, par exemple administrateur ou utilisateur final. Vous pouvez assigner différentes autorisations aux utilisateurs en fonction de leur rôle.">Gestion des utilisateurs</th>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Et plus encore!</th>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="feature-icon text-primary align-self-center pr-4">
                                            <span><i class="fas fa-check-circle fa-2x"></i></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table><br>
                        <p class="text-center"> Vous avez le choix de choisir les fonctionnalités adaptées à votre club. </p>
                        <p class="text-center">Remplacez les processus manuels grâce à un logiciel intuitif</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section backg  overlay-dark overflow-hidden ptb_100">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-4">
                        <!-- Service Text -->
                        <div class="service-text pt-4 pt-lg-0">
                            <h2 class="promo-text text-white mb-4">Tester gratuitement</h2>
                            <p class="text-white pt-3">Testez dès aujourd’hui TeknoClub pendant 14 jours, sans engagement!</p>
                        </div>
                        <div class="button-group store-buttons d-flex">
                            <a target="_blank" href="{{route('login')}}" class="btn prolend-primary style-three text-uppercase">Démonstration gratuit</a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <!-- Service Thumb -->
                        <div class="service-thumb mx-auto text-center pt-4 pt-lg-0">
                            <img src="{{ asset('/landing_assets/img/07.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ***** FAQ Area End ***** -->
        <!--====== Contact Area Start ======-->
        <section id="contact" class="bg-gray contact-area ptb_100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-6">
                        <!-- Section Heading -->
                        <div class="section-heading text-center">
                            <h2 class="text-capitalize">Formulaire de contact</h2>
                            <p class="d-none d-sm-block mt-4">Vous avez des questions ? Contactez-nous !</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        <!-- Contact Box -->
                        <div class="contact-box text-center">
                            <!-- Contact Form -->
                            <form id="contact-form" method="POST" action="">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Nom Complet *" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email *" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="subject" placeholder="Sujet *" required="required">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" placeholder="Message *" required="required"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn mt-3"><span class="text-white pr-3"><i class="fas fa-paper-plane"></i></span>Envoyer</button>
                                    </div>
                                </div>
                            </form>
                            <p class="form-message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--====== Contact Area End ======-->
        <!--====== Footer Area Start ======-->
        <footer class="footer-area dark-bg">
            <div class="footer-top ptb_50">
                <div class="container">
                    <div class="row  d-flex flex-wrap justify-content-center justify-content-sm-between  py-4">
                        <div class="logo-footer col-12 col-sm-6 col-lg-3">
                            <div class="footer-items">
                                <a class="scroll d-flex justify-content-center align-items-center navbar-brand" href="#accueil">
                                    <img style="width: 218px;" class="logo" src="{{ asset('/landing_assets/img/logo/favicon32.png')}}" alt="TeknoSolvo, TeknoClub, Agence de création de site internet, application web et mobile."><br>
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