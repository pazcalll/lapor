<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <table id="finished_report" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <td>No. Pelaporan</td>
                    <td>Waktu Pelaporan</td>
                    <td>Waktu Penugasan</td>
                    <td>Waktu Selesai</td>
                    <td>Fasilitas</td>
                    <td>Deskripsi Laporan</td>
                    <td>Dokumen Pendukung / Bukti</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- Header End -->

<!-- Modal -->
<div class="modal fade" id="detailFinishedModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input class="form-control" disabled name="opd" id="opd">
                            <label for="opd">Penanggung Jawab</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input class="form-control" disabled name="reporter" id="reporter">
                            <label for="reporter">Pelapor</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input class="form-control" disabled name="location" id="location">
                            <label for="location">Lokasi</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" disabled style="height: 100px" name="issue" id="issue" placeholder="Deskripsi" cols="30" rows="50"></textarea>
                            <label for="issue">Deskripsi</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" disabled style="height: 100px" name="additional" id="additional" placeholder="Informasi Tambahan" cols="30" rows="50"></textarea>
                            <label for="additional">Informasi Tambahan</label>
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
    $('#title-label').html("Laporan Selesai")
    getFinishedReports("{{ asset('storage/proof') }}")
</script>