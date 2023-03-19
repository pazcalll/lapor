<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <table id="incoming_report" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <th></th>
                    <td>No. Pelaporan</td>
                    <td>Waktu Pelaporan</td>
                    <td>Fasilitas</td>
                    <td>OPD</td>
                    <td>Deskripsi Laporan</td>
                    <td>Dokumen Pendukung / Bukti</td>
                    <td>Status</td>
                    <td>Tindakan</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- Header End -->

<!-- Modal -->
<div class="modal fade" id="prosesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Proses Laporan</h5>
                <button type="button" class="btn-close close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="processReport(event)" id="processReport">
                @method("POST")
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>Referral : </span><span class="referral_modal"></span>
                                <input type="hidden" class="float-right" name="referral" id="referral">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="opd">OPD</label>
                                <select name="opd" id="opd" class="opd-select form-control" aria-placeholder="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Batas Waktu Penanganan</label>
                                <input type="date" class="form-control" id="deadline_at" name="deadline_at">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional">Informasi Tambahan</label>
                                <textarea class="form-control" style="height: 100px" name="additional" id="additional" placeholder="Informasi Tambahan (Opsional)" cols="30" rows="50"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Proses</button>
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

<!-- Modal -->
<div class="modal fade" id="confirmOPDModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Perubahan OPD</h5>
                <button type="button" class="btn-close close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="processReport(event)">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>Referral : </span><span class="referral_confirmOPD"></span>
                                <input type="hidden" name="referral" id="referral">
                                <input type="hidden" name="additional" value="" id="additional">
                                <input type="hidden" name="opd" id="opd">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional">
                                    Mengubah OPD berarti menyetujui laporan dan menyerahkan laporan kepada OPD terkait untuk ditindak lanjuti. 
                                    Apakah anda ingin mengganti OPD dari laporan ini menjadi <strong class="opd_spill"></strong>?
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Ganti OPD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Penolakan Laporan</h5>
                <button type="button" class="btn-close close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectReport" onsubmit="rejectReport(event)">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>Referral : </span><span class="referral_reject"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <p for="additional">Apakah anda ingin menolak laporan ini? </p>
                                <input type="hidden" name="rejectReferral" id="rejectReferral">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Penolakan Laporan</h5>
                <button type="button" class="btn-close close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="editReportDetail(event)">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Referral : </span><span class="referral_modal"></span>
                                <input type="hidden" disabled class="form-control" name="referral_detail" id="referral_detail">
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
                                        <input type="text" class="form-control mt-1 mb-1" id="street" name="street" placeholder="Nama Jalan">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control mt-1 mb-1" id="rt" name="rt" placeholder="RT">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control mt-1 mb-1" id="rw" name="rw" placeholder="RW">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control mt-1 mb-1" id="village" name="village" placeholder="Desa">
                                        <input type="text" class="form-control mt-1 mb-1" id="sub_district" name="sub_district" placeholder="Kecamatan">
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-1">
                            <div class="form-floating">
                                <label for="issue">Deskripsi</label>
                                <textarea class="form-control" style="height: 100px" name="issue" id="issue" placeholder="Deskripsi" cols="30" rows="50"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#title-label").html('Laporan Masuk')

    incomingReportDatatable('{{ asset("storage/proof") }}')
    getOpds()
</script>