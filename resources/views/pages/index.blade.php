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
                    <a href="javascript:void(0)" class="dropdown-item">Buat Baru</a>
                    <a href="javascript:void(0)" class="dropdown-item">Riwayat</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle customer-drop" data-bs-toggle="dropdown">Pengguna</a>
                <div class="dropdown-menu shadow-sm m-0">
                    <a href="javascript:void(0)" class="dropdown-item">Profil</a>
                    <a onclick="logout()" href="javascript:void(0)" class="dropdown-item text-danger">Logout</a>
                </div>
            </div>
        </div>
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
                <button data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary py-3 px-4 animated slideInDown" style="border-radius: 64px"><i class="fa fa-plus-circle" aria-hidden="true"></i> Buat Laporan Sekarang</button>
            </div>
            <div class="col-lg-6 animated fadeIn">
                <img class="img-fluid animated pulse infinite" style="animation-duration: 3s; max-width: 480px; max-height: 480px" src="img/danger.png"
                    alt="">
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="makeReport">
                @method("POST")
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="location" name="location" placeholder="Lokasi">
                                <label for="location">Lokasi</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <select name="facility" id="facility" class="form-select" aria-placeholder="">
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                {{-- <input type="password" class="form-control" id="password" name="password" placeholder="Password"> --}}
                                <textarea class="form-control" style="height: 100px" name="issue" id="issue" placeholder="Detail Masalah" cols="30" rows="50"></textarea>
                                <label for="issue">Detail Masalah</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="file" name="proof" id="proof" class="dropify" required type="file" data-plugin="dropify" data-max-file-size="1M" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Buat Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
        class="bi bi-arrow-up"></i></a>

<script>
    $('.dropify').dropify({
        messages: {
            'default': 'Masukkan bukti',
            'replace': 'Masukkan ganti dengan bukti lain',
            'remove':  'Hapus',
            'error':   'Maaf, terjadi kesalahan.'
        },
        error: {
            'fileSize': 'Ukuran terlalu besar (1 mb max).',
        }
    })
    $('#makeReport').on('submit', function (e) {  
        e.preventDefault()
        let fd = new FormData()
        fd.append('proof', $('#proof')[0].files[0])
        fd.append('issue', $('#issue').val())
        fd.append('facility', $('#facility').val())
        fd.append('location', $('#location').val())
        fd.append('_token', "{{ csrf_token() }}")
        // for (var pair of fd.entries()) {
        //     console.log(pair[0]+ ', ' + pair[1]); 
        // }
        $.ajax({
            url: '{{ route("createReport") }}',
            type: 'POST',
            headers: {
                Authorization: 'bearer' + localStorage.getItem('_token')
            },
            data: fd,
            contentType: false,
            processData: false,
            success: (res) => {
                console.log(res)
            },
            error: (err) => {
                console.log(err)
            }
        })
    })
</script>