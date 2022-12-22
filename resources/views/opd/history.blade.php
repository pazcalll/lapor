<!-- Header Start -->
<div class="container-fluid hero-header bg-light py-5 mb-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <h1 class="display-4 mb-3">Riwayat Tugas</h1>
            <table id="finished_assignments" class="table table-striped table-borderless" style="width: 100%">
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

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Laporan</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <input class="form-control" disabled name="opd_detail" id="opd_detail">
                            <label for="opd">Penanggung Jawab</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input class="form-control" disabled name="reporter_detail" id="reporter_detail">
                            <label for="reporter">Pelapor</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input class="form-control" disabled name="location_detail" id="location_detail">
                            <label for="location">Lokasi</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" disabled style="height: 100px" name="issue_detail" id="issue_detail" placeholder="Deskripsi" cols="30" rows="50"></textarea>
                            <label for="issue">Deskripsi</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" disabled style="height: 100px" name="additional_detail" id="additional_detail" placeholder="Informasi Tambahan" cols="30" rows="50"></textarea>
                            <label for="additional">Informasi Tambahan</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <table style="width: 100%">
                                <tr>
                                    <td width="20%">
                                        <span>Bukti Laporan : </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-proof w-100" data-proof="">Bukti Laporan</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    getFinishedAssignments()
    $('.btn-proof').on('click', function () {  
        window.open(webBaseUrl+"/"+$(this).data('proof'), '_blank');
    })
</script>