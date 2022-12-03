<!-- Header Start -->
<div class="container-fluid hero-header bg-light py-5 mb-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <h1 class="display-4 mb-3">Tugas Masuk</h1>
            <table id="incoming_report" class="table table-striped table-borderless" style="width: 100%">
                <thead>
                    <tr>
                        <td>Referral</td>
                        <td>Pelapor</td>
                        <td>Waktu Laporan</td>
                        <td>Waktu Penugasan</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<!-- Header End -->

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
</script>