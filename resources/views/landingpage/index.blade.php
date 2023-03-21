<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Wadul Gus'e</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('landingpage/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('landingpage/css/bootstrap-icons.css')}}" rel="stylesheet">

        <link href="{{ asset('landingpage/css/owl.carousel.min.css')}}" rel="stylesheet">

        <link href="{{ asset('landingpage/css/owl.theme.default.min.css')}}" rel="stylesheet">

        <link href="{{ asset('landingpage/css/templatemo-medic-care.css')}}" rel="stylesheet">
<!--

TemplateMo 566 Medic Care

https://templatemo.com/tm-566-medic-care

-->
    </head>
    
    <body id="top">
    
        <main>

            <nav class="navbar navbar-expand-lg bg-light fixed-top shadow-lg">
                <div class="container">
                    <a class="navbar-brand mx-auto d-lg-none" href="index.html">
                        Wadul Gus'e
                        <strong class="d-block">Gresik</strong>
                    </a>
                    <a href="index.html" class="logo">
                        <img height="90" width="90" src="{{ asset('landingpage/images/gallery/logo1.png')}}">
                                  </a>
                    <a href="index.html" class="logo">
                        <img height="90" width="150" src="{{ asset('landingpage/images/gallery/logo.svg')}}">
                                  </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mx-auto">
                               
                            <li class="nav-item active">
                                <a class="nav-link" href="#hero">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#about">Tentang</a>
                            </li>                        

                            <a class="navbar-brand d-none d-lg-block" href="index.html">
                                Wadul Gus'e
                                <strong class="d-block">Gresik</strong>
                            </a>

                             <li class="nav-item">
                                <a class="nav-link" href="#timeline">Pelaporan</a>

                            </li><li class="nav-item">
                                <a class="nav-link" href="<?= url('login'); ?>">Login</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>

            <section class="hero" id="hero">
                <div class="container">
                    <div class="row">

                        <div class="col-12">

                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('landingpage/images/gallery/bupati.png')}}" class="img-fluid" alt="">
                                    </div>

                                     </div>
                                </div>
                            </div>

                            <div class="heroText d-flex flex-column justify-content-center">

                                <h2 class="mt-auto mb-2">
                                    Wadul Gus'e
                                    <div class="animated-info">
                                        <span class="animated-item">itu apa?</span>
                                        <span class="animated-item">untuk apa?</span>
                                    </div>

                                </h2>

                                <p class="mb-4">Wadul Gus’e merupakan perangkat lunak (software) yang dikembangkan untuk membantu aktivitas pelaporan atau laporan terhadap layanan public yang tersedia di Kabupaten Gresik.</p>

                                <div class="heroLinks d-flex flex-wrap align-items-center">
                                    <a class="custom-link me-4" href="#about" data-hover="Lebih Lanjut">Lebih Lanjut</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="section-padding" id="about">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-12">
                            <h2 class="mb-lg-3 mb-3" align="text-center">Apa itu Wadul Gus'e ?</h2>
                            <p align="justify">Wadul Gus’e merupakan perangkat lunak (software) yang dikembangkan untuk
                            membantu aktivitas pelaporan atau laporan terhadap layanan public yang tersedia di Kabupaten Gresik. </p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <h2 class="mb-lg-3 mb-3">Wadul Gus'e untuk apa ?</h2>
                            <p align="justify"> Aplikasi Wadul Gus’e ini membantu para ketua RT dan RW untuk dapat melaporkan masalah-masalah yang biasanya ditemui pada lingkungan. Selanjutnya laporan/laporan yang masuk ke aplikasi dapat diverifikasi oleh petugas admin untuk selanjutnya di disposisikan ke OPD terkait. OPD yang menindaklanjuti laporan juga dapat memberikan laporan berupa bukti penanganan berupa foto dsb. Dengan adanya aplikasi ini penanganan permsalahan yang berhubungan dengan fasilitas public di lingkungan masyarakat dapat di selesaikan dengan cepat dan terdokumentasi dengan baik.</p>
                        </div>
            </section>
            <section class="section-padding pb-0" id="timeline">
                <div class="container">
                    <div class="row">

                        <h2 class="text-center mb-lg-5 mb-4">Langkap Pelaporan</h2>
                        
                        <div class="timeline">
                            <div class="row g-0 justify-content-end justify-content-md-around align-items-start timeline-nodes">
                                <div class="col-9 col-md-5 me-md-4 me-lg-0 order-3 order-md-1 timeline-content bg-white shadow-lg">
                                    <h3 class=" text-light">Login ke Aplikasi</h3>

                                    <p align="justify">Untuk membuat sebuah laporan, pengguna yang sudah memiliki akun perlu login ke aplikasi terlebih dahulu.</p>
                                </div>

                                <div class="col-3 col-sm-1 order-2 timeline-icons text-md-center">
                                    <i class="bi-person timeline-icon"></i>
                                </div>

                                <div class="col-9 col-md-5 ps-md-3 ps-lg-0 order-1 order-md-3 py-4 timeline-date">
                                    <time>Langkah 1</time>
                                </div>
                            </div>

                            <div class="row g-0 justify-content-end justify-content-md-around align-items-start timeline-nodes my-lg-5 my-4">
                                <div class="col-9 col-md-5 ms-md-4 ms-lg-0 order-3 order-md-1 timeline-content bg-white shadow-lg">
                                    <h3 class=" text-light">Membuat Laporan</h3>

                                    <p align="justify">Laporan dapat dibuat dengan mengisi form yang disediakan oleh sistem. Bukti berupa gambar juga bisa dimasukkan.</p>
                                </div>

                                <div class="col-3 col-sm-1 order-2 timeline-icons text-md-center">
                                    <i class="bi-book timeline-icon"></i>

                                </div>

                                <div class="col-9 col-md-5 pe-md-3 pe-lg-0 order-1 order-md-3 py-4 timeline-date">
                                    <time>Langkah 2</time>
                                </div>
                            </div>

                            <div class="row g-0 justify-content-end justify-content-md-around align-items-start timeline-nodes">
                                <div class="col-9 col-md-5 me-md-4 me-lg-0 order-3 order-md-1 timeline-content bg-white shadow-lg">
                                    <h3 class=" text-light">Cek Status Laporan</h3>

                                    <p align="justify">Status dari laporan yang telah diberikan dapat dilihat melalui fitur yang disediakan oleh sistem.</p>
                                </div>

                                <div class="col-3 col-sm-1 order-2 timeline-icons text-md-center">
                                    <i class="bi-file-medical timeline-icon"></i>
                                </div>

                                <div class="col-9 col-md-5 ps-md-3 ps-lg-0 order-1 order-md-3 py-4 timeline-date">
                                    <time>Langkah 3</time>
                                </div>
                            </div>

                            <div class="row g-0 justify-content-end justify-content-md-around align-items-start timeline-nodes my-lg-5 my-4">
                                <div class="col-9 col-md-5 ms-md-4 ms-lg-0 order-3 order-md-1 timeline-content bg-white shadow-lg">
                                    <h3 class=" text-light">Feedback</h3>                                    
                                    <p align="justify">Feedback bisa diberikan setelah laporan selesai ditindak lanjuti oleh pihak terkait</p>
                                </div>

                                <div class="col-3 col-sm-1 order-2 timeline-icons text-md-center">
                                    <i class="bi-globe timeline-icon"></i>
                                </div>

                                <div class="col-9 col-md-5 pe-md-3 pe-lg-0 order-1 order-md-3 py-4 timeline-date">
                                    <time>Langkah 4</time>
                                </div>
                            </div>

                            <div class="row g-0 justify-content-end justify-content-md-around align-items-start timeline-nodes">
                                <div class="col-9 col-md-5 me-md-4 me-lg-0 order-3 order-md-1 timeline-content bg-white shadow-lg">
                                    <h3 class=" text-light">Selesai</h3>

                                    <p align="justify">Pada titik ini laporan dianggap selesai dan tidak akan ada tindakan lebih lanjut kedepannya.</p>
                                </div>

                                <div class="col-3 col-sm-1 order-2 timeline-icons text-md-center">
                                    <i class="bi-patch-check-fill timeline-icon"></i>
                                </div>

                                <div class="col-9 col-md-5 ps-md-3 ps-lg-0 order-1 order-md-3 py-4 timeline-date">
                                    <time>Langkah 5</time>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>           
        </main>

        <footer class="navbar navbar-expand-lg bg-light fixed-down shadow-lg align-items-center">
            <div class="container">
            <a href="index.html" class="logo">
                        <img height="90" width="150" src="{{ asset('landingpage/images/gallery/logo.svg')}}">
                                  </a>
            <h4 class="copyright-text" align="center">Copyright © 2023 Dinas Komunikasi dan Informatika </h4>
           </div>
            </section>
        </footer>

        <!-- JAVASCRIPT FILES -->
        <script src="{{ asset('landingpage/js/jquery.min.js')}}"></script>
        <script src="{{ asset('landingpage/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('landingpage/js/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('landingpage/js/scrollspy.min.js')}}"></script>
        <script src="{{ asset('landingpage/js/custom.js')}}"></script>
<!--

TemplateMo 566 Medic Care

https://templatemo.com/tm-566-medic-care

-->
    </body>
</html>