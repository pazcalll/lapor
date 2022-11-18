<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lapor | Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="{{ asset('lib/axios/axios.min.js') }}"></script>
    <script src="{{ asset('js/authRouter.js') }}"></script>
</head>

<body>
    <!-- Header Start -->
    <div class="container-fluid hero-header py-5 mb-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 mb-3 animated slideInDown">Aplikasi Lapor</h1>
                    <p class="animated slideInDown">
                        Sebuah aplikasi yang dibuat untuk memproses laporan atau aduan masyarakat
                        terhadap suatu masalah yang terjadi di lingkup kota ini dengan sistem yang
                        manusiawi.
                    </p>
                    <a href="#form-content" class="btn btn-primary py-3 px-4 animated slideInDown">Login</a>
                </div>
                <div class="col-lg-6 animated fadeIn">
                    <img class="img-fluid animated pulse infinite" style="animation-duration: 3s;" src="https://img.freepik.com/free-vector/smiling-man-talking-loudspeaker-monitor-social-media-computer-online-flat-vector-illustration-communication-digital-technology_74855-13238.jpg"
                        alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container-xxl bg-light py-5 my-5">
        <div class="container py-5">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6">Langkah Pelaporan</h1>
                {{-- <p class="text-primary fs-5 mb-5">Buy, Sell And Exchange Cryptocurrency</p> --}}
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item bg-white p-5">
                        {{-- <img class="img-fluid mb-4" src="img/icon-7.png" alt=""> --}}
                        <p style="font-weight: bold"><a href="javascript:void(0)">Langkah 1</a></p>
                        <i class="fa fa-user-plus fa-4x mb-4" style="color: #16d5ff" aria-hidden="true"></i>
                        <h5 class="mb-3">Mendaftar ke Aplikasi</h5>
                        <p>Untuk membuat sebuah laporan, pengguna memerlukan akun untuk diidentifikasi oleh sistem.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item bg-white p-5">
                        {{-- <img class="img-fluid mb-4" src="img/icon-7.png" alt=""> --}}
                        <p style="font-weight: bold"><a href="javascript:void(0)">Langkah 2</a></p>
                        <i class="fa fa-file fa-4x mb-4" style="color: #16d5ff" aria-hidden="true"></i>
                        <h5 class="mb-3">Membuat Laporan</h5>
                        <p>
                            Laporan dapat dibuat dengan mengisi form yang disediakan oleh sistem. Bukti berupa
                            gambar juga bisa dimasukkan.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item bg-white p-5">
                        {{-- <img class="img-fluid mb-4" src="img/icon-7.png" alt=""> --}}
                        <p style="font-weight: bold"><a href="javascript:void(0)">Langkah 3</a></p>
                        <i class="fa fa-check-square fa-4x mb-4" style="color: #16d5ff" aria-hidden="true"></i>
                        <h5 class="mb-3">Cek Status Laporan</h5>
                        <p>
                            Status dari laporan yang telah diberikan dapat dilihat melalui fitur yang disediakan 
                            oleh sistem.  
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item bg-white p-5">
                        {{-- <img class="img-fluid mb-4" src="img/icon-7.png" alt=""> --}}
                        <p style="font-weight: bold"><a href="javascript:void(0)">Langkah 4</a></p>
                        <i class="fa fa-comment fa-4x mb-4" style="color: #16d5ff" aria-hidden="true"></i>
                        <h5 class="mb-3">Feedback</h5>
                        <p>
                            Feedback bisa diberikan setelah laporan selesai ditindak lanjuti oleh pihak terkait.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item bg-white p-5">
                        {{-- <img class="img-fluid mb-4" src="img/icon-7.png" alt=""> --}}
                        <p style="font-weight: bold"><a href="javascript:void(0)">Langkah 5</a></p>
                        <i class="fa fa-flag-checkered fa-4x mb-4" style="color: #16d5ff" aria-hidden="true"></i>
                        <h5 class="mb-3">Selesai</h5>
                        <p>
                            Pada titik ini laporan dianggap selesai dan tidak akan ada tindakan lebih lanjut
                            kedepannya.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Start -->
    <span class="d-flex align-items-center justify-content-center visually-hidden form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 100%; align-content: center">
        <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </span>
    </span>
    <div class="container-xxl py-5 auth-content" style="margin-bottom: 200px">
        <div class="container" id="form-content">
            <div class="row g-5 mb-5 wow fadeInUp">
                <div class="col-lg-6">
                    <h1 class="display-6">Login Sekarang</h1>
                    <p class="text-primary fs-5 mb-0">Laporkan masalah publik yang ada disekitar</p>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                    <p class="mb-4">Belum punya akun? klik di <a class="fs-5" style="background-color: yellow" onclick="registerPage()" href="javascript:void(0)">sini</a></p>
                    <form>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                    <label for="username">Username</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary py-3 px-4" type="submit">Login Sekarang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>