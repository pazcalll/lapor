<!-- Header Start -->
<div class="container-fluid hero-header bg-light py-5 mb-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <h1 class="display-4 mb-3">Laporan Selesai</h1>
            <table id="finished_report" class="table table-striped table-borderless" style="width: 100%">
                <thead>
                    <tr>
                        <td>Referral</td>
                        <td>Penanggung Jawab</td>
                        <td>Tanggal Penugasan</td>
                        <td>Tanggal Selesai</td>
                        <td>Tindakan</td>
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
                            <input class="form-control" disabled name="officer" id="officer">
                            <label for="officer">Penanggung Jawab</label>
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
    getFinishedReports("{{ asset('storage/proof') }}")
</script>