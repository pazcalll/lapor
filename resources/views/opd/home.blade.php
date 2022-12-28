<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <table id="incoming_assignment" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <td>No. Pelaporan</td>
                    <td>Pembuat Laporan</td>
                    <td>Waktu Pelaporan</td>
                    <td>Waktu Penugasan</td>
                    <td>Fasilitas</td>
                    <td>Deskripsi Laporan</td>
                    <td>Status</td>
                    <td>Dokumen Pendukung / Bukti</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- Header End -->

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Laporan</h5>
                <button type="button" class="btn-close btn btn-danger modal-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <span>Referral : </span><span class="referral_modal"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <label for="opd">OPD</label>
                            <input class="form-control" disabled name="opd_detail" id="opd_detail">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <label for="reporter">Pelapor</label>
                            <input class="form-control" disabled name="reporter_detail" id="reporter_detail">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <label for="location">Lokasi</label>
                            <div id="location" name="location">
                                <div class="page-heading">
                                    <label for="street">Jalan</label>
                                    <input disabled type="text" class="form-control mt-1 mb-1" id="street" name="street" placeholder="Nama Jalan">
                                    <label for="">RT/RW</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input disabled type="text" class="form-control mt-1 mb-1" id="rt" name="rt" placeholder="RT">
                                        </div>
                                        <div class="col-md-6">
                                            <input disabled type="text" class="form-control mt-1 mb-1" id="rw" name="rw" placeholder="RW">
                                        </div>
                                    </div>
                                    <label for="">Desa</label>
                                    <input disabled type="text" class="form-control mt-1 mb-1" id="village" name="village" placeholder="Desa">
                                    <label for="">Kecamatan</label>
                                    <input disabled type="text" class="form-control mt-1 mb-1" id="sub_district" name="sub_district" placeholder="Kecamatan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <label for="issue">Deskripsi</label>
                            <textarea class="form-control" disabled style="height: 100px" name="issue_detail" id="issue_detail" placeholder="Deskripsi" cols="30" rows="50"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <label for="additional">Informasi Tambahan</label>
                            <textarea class="form-control" disabled style="height: 100px" name="additional_detail" id="additional_detail" placeholder="Informasi Tambahan" cols="30" rows="50"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="finishModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selesaikan Laporan</h5>
                <button type="button" class="btn-close btn btn-danger modal-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form onsubmit="finishAssignment(event)" id="finishAssignmentForm">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Referral : </span><span class="referral_modal_finish"></span>
                                <input type="hidden" name="referral_finish" id="referral_finish">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <label for="file_finish">Bukti Selesai</label>
                                <input class="dropify" type="file" name="file_finish" id="file_finish" data-max-file-size="1M">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim Bukti Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bukti Laporan</h5>
                <button type="button" class="btn-close close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <span>Referral : </span><span class="referral_proof"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="additional">Bukti yang dilampirkan: </label>
                            <div class="proof-container">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#title-label").html('Tugas Masuk')
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
    getIncomingAssignments()
</script>