<div class="gx-card">
    <div class="gx-card-body">
        <p style="color: gray; text-align: center">Tata cara pembuatan laporan</p>
        <form id="rootwizard" class="form-horizontal form-wizard">
            <div class="wizard-navbar">
                <ul class="nav wizard-steps">
                    <li class="completed"><a href="#tab1" data-toggle="tab"><span class="wz-number">1</span> <span class="wz-label">Mendaftar ke Aplikasi</span></a></li>
                    <li class="completed"><a href="#tab2" data-toggle="tab"><span class="wz-number">2</span> <span class="wz-label">Membuat Laporan</span></a></li>
                    <li class="completed"><a href="#tab3" data-toggle="tab"><span class="wz-number">3</span> <span class="wz-label">Cek Status Laporan</span></a></li>
                    <li class="completed"><a href="#tab4" data-toggle="tab"><span class="wz-number">4</span> <span class="wz-label">Feedback</span></a></li>
                    <li class="completed"><a href="#tab5" data-toggle="tab"><span class="wz-number">5</span> <span class="wz-label">Selesai</span></a></li>
                </ul>
            </div>
        </form>
    </div>
</div>

<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <div class="col-lg-12">
            <table class="table table-striped table-borderless" id="report_queue" style="width: 100%">
                <thead>
                    <tr>
                        <td>No. Pelaporan</td>
                        <td>Waktu Pelaporan</td>
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
    $('#title-label').html('Antrean Laporan')
</script>