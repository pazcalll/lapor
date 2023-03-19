<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <table id="inprocess_report" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <td>Referral</td>
                    <td>OPD</td>
                    <td>Tanggal Penugasan</td>
                    <td>Tanggal Deadline</td>
                    <td>Tindakan</td>
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
                <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <span>Referral : </span><span class="referral_modal"></span>
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                        <div class="form-floating">
                            <label for="opd">OPD</label>
                            <input disabled class="form-control" name="opd" id="opd">
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                        <div class="form-floating">
                            <label for="reporter">Pelapor</label>
                            <input disabled class="form-control" name="reporter" id="reporter">
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                        <div class="form-floating">
                            <label for="location">Lokasi</label>
                                <div id="location" name="location">
                                    <input disabled type="text" class="form-control mt-1 mb-1" id="street" name="street" placeholder="Nama Jalan">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input disabled type="text" class="form-control mt-1 mb-1" id="rt" name="rt" placeholder="RT">
                                        </div>
                                        <div class="col-md-6">
                                            <input disabled type="text" class="form-control mt-1 mb-1" id="rw" name="rw" placeholder="RW">
                                        </div>
                                    </div>
                                    <input disabled type="text" class="form-control mt-1 mb-1" id="village" name="village" placeholder="Desa">
                                    <input disabled type="text" class="form-control mt-1 mb-1" id="sub_district" name="sub_district" placeholder="Kecamatan">
                                </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                        <div class="form-floating">
                            <label for="issue">Deskripsi</label>
                            <textarea disabled class="form-control" style="height: 100px" name="issue" id="issue" placeholder="Deskripsi" cols="30" rows="50"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                        <div class="form-floating">
                            <label for="additional">Informasi Tambahan</label>
                            <textarea disabled class="form-control" style="height: 100px" name="additional" id="additional" placeholder="Informasi Tambahan" cols="30" rows="50"></textarea>
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
    $('#title-label').html('Laporan Diproses')
    getAcceptedReports("{{ asset('storage/proof') }}")
</script>