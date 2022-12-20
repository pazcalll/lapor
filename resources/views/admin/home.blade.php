<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <table id="incoming_report" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <td>Referral</td>
                    <td>Deskripsi Laporan</td>
                    <td>Waktu Laporan</td>
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
                                <label for="officer">Pegawai</label>
                                <select name="officer" id="officer" class="form-select form-control" aria-placeholder="">
                                </select>
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
                            <span>Referral : </span><span class="referral_modal"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="officer">Pegawai</label>
                            <select name="officer" id="officer" class="form-select form-control" aria-placeholder="">
                            </select>
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
    $("#title-label").html('Laporan Masuk')

    incomingReportDatatable('{{ asset("storage/proof") }}')
    getOfficers()
</script>