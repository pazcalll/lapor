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
                                <label for="location">Lokasi <span style="color: red">*</span></label>
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
                                <label for="facility">Fasilitas <span style="color: red">*</span></label>
                                <select name="facility" id="facility" class="form-control mt-1 mb-1" aria-placeholder="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="opd">OPD (Organisasi Perangkat Daerah) <span style="color: red">*</span></label>
                                <select name="opd" id="opd" class="form-control mt-1 mb-1" aria-placeholder="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="issue">Detail Masalah <span style="color: red">*</span></label>
                                <textarea class="form-control mt-1 mb-1" style="height: 100px" name="issue" id="issue" placeholder="Detail Masalah" cols="30" rows="50"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 proof-container">
                            <label>Bukti <span style="color: red">*</span></label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <input type="file" name="proof" id="proof" class="dropify" required type="file" data-plugin="dropify" data-max-file-size="1M" >
                                </div>
                                <div class="col-sm-2 justify-content-center align-self-center uploader-adder">
                                    <button type="button" onclick="addFileUploader()" class="btn btn-success" title="Tambah Masukan Bukti" style="border-radius: 10px; height: max-content; transform: translateY(-50%); position: absolute; top: 50%; bottom: 50%;">
                                        <i class="zmdi zmdi-plus zmdi-hc-4x"></i>
                                    </button>
                                </div>
                            </div>
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
        },
        tpl: {
            clearButton: '<button type="button" onclick="removeFileInput(this)" class="dropify-clear">Hapus</button>'
        }
    })
    
</script>