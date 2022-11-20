<!-- Spinner Start -->
<div id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End -->


<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 px-4 px-lg-5">
    <a href="index.html" class="navbar-brand d-flex align-items-center">
        <h2 class="m-0 text-primary">Lapor</h2>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-4 py-lg-0">
            <a href="index.html" class="nav-item nav-link active">Home</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Laporan</a>
                <div class="dropdown-menu shadow-sm m-0">
                    <a href="faq.html" class="dropdown-item">Buat Baru</a>
                    <a href="404.html" class="dropdown-item">Riwayat</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle customer-drop" data-bs-toggle="dropdown">Pengguna</a>
                <div class="dropdown-menu shadow-sm m-0">
                    <a href="faq.html" class="dropdown-item">Profil</a>
                    <a href="404.html" class="dropdown-item text-danger">Logout</a>
                </div>
            </div>
        </div>
        {{-- <div class="h-100 d-lg-inline-flex align-items-center d-none">
            <a class="btn btn-square rounded-circle bg-light text-primary me-2" href=""><i
                    class="fab fa-facebook-f"></i></a>
            <a class="btn btn-square rounded-circle bg-light text-primary me-2" href=""><i
                    class="fab fa-twitter"></i></a>
            <a class="btn btn-square rounded-circle bg-light text-primary me-0" href=""><i
                    class="fab fa-linkedin-in"></i></a>
        </div> --}}
    </div>
</nav>
<!-- Navbar End -->


<!-- Header Start -->
<div class="container-fluid hero-header bg-light py-5 mb-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 mb-3 animated slideInDown">Lapor</h1>
                <p class="animated slideInDown">Sampaikan laporan atau aduan anda kepada pihak yang berwenang di 
                    dalam situs ini secara langsung!</p>
                <a href="" class="btn btn-primary py-3 px-4 animated slideInDown" style="border-radius: 64px"><i class="fa fa-plus-circle" aria-hidden="true"></i> Buat Laporan Sekarang</a>
            </div>
            <div class="col-lg-6 animated fadeIn">
                <img class="img-fluid animated pulse infinite" style="animation-duration: 3s; max-width: 480px; max-height: 480px" src="img/danger.png"
                    alt="">
            </div>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
        class="bi bi-arrow-up"></i></a>