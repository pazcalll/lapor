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
            <a onclick="homePage()" href="javascript:void(0)" id="home" class="nav-item nav-link active">Home</a>
            <a onclick="reportPage()" href="javascript:void(0)" id="report" class="nav-item nav-link">Laporan</a>
            <a onclick="reportHistoryPage()" href="javascript:void(0)" class="nav-item nav-link" id="history">Riwayat</a>
            <div class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link dropdown-toggle customer-drop" data-bs-toggle="dropdown">Pengguna</a>
                <div class="dropdown-menu shadow-sm m-0">
                    <a href="javascript:void(0)" class="dropdown-item" id="profile">Profil</a>
                    <a onclick="logout()" href="javascript:void(0)" id="logout" class="dropdown-item text-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->
<div id="content">
    <script>
        $.ajax({
            url: webBaseUrl + '/customer/home-page',
            type: "GET",
            headers: {
                Authorization: 'bearer ' + localStorage.getItem('_token')
            },
            success: (res) => {
                $('#content').html(res)
            },
            error: (err) => {
                console.log(err)
                $('#content').html(err)
            }
        })
    </script>
</div>