<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <div class="col-lg-6">
            <p class="animated slideInDown" style="font-size: 24pt">Sampaikan laporan atau aduan anda kepada pihak yang berwenang di 
                dalam situs ini secara langsung!</p>
            <button data-backdrop="false" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary py-3 px-4 animated slideInDown" style="border-radius: 64px; font-size: 12pt">
                <i class="zmdi zmdi-collection-plus"></i>
            </i> Buat Laporan Sekarang</button>
        </div>
        <div class="col-lg-6 animated fadeIn">
            <img class="img-fluid animated pulse infinite" style="animation-duration: 3s; max-width: 480px; max-height: 480px" src="img/danger.png"
                alt="">
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
                <button type="button" class="btn-close close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="makeReport">
                @method("POST")
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="location">Lokasi</label>
                                <div id="location" name="location">
                                    <input type="text" class="form-control mt-1 mb-1" id="road" name="road" placeholder="Nama Jalan">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mt-1 mb-1" id="rt" name="rt" placeholder="RT">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mt-1 mb-1" id="rw" name="rw" placeholder="RW">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control mt-1 mb-1" id="village" name="village" placeholder="Desa">
                                    <input type="text" class="form-control mt-1 mb-1" id="district" name="district" placeholder="Kecamatan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="facility">Fasilitas</label>
                                <select name="facility" id="facility" class="form-control mt-1 mb-1" aria-placeholder="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="opd">OPD (Organisasi Perangkat Daerah)</label>
                                <select name="opd" id="opd" class="form-control mt-1 mb-1" aria-placeholder="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="issue">Detail Masalah</label>
                                <textarea class="form-control mt-1 mb-1" style="height: 100px" name="issue" id="issue" placeholder="Detail Masalah" cols="30" rows="50"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 proof-container">
                            <input type="file" name="proof" id="proof" class="dropify" required type="file" data-plugin="dropify" data-max-file-size="1M" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Buat Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>    
    $("#title-label").html('Buat Laporan')
    
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
        
        $('.btn-close').click()
        $('#issue').val(null)
        $('#facility').val(null)
        $('#location').val(null)

        $.ajax({
            url: '{{ route("createReport") }}',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: (res) => {
                toastr.success('Laporan terkirim!')
                console.log(res)
            },
            error: (err) => {
                toastr.error('Laporan gagal terkirim')
                console.log(err)
            }
        })
    })
    
</script>