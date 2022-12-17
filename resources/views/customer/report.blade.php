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
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-12">
                <table class="table table-striped table-borderless" id="report_queue" style="width: 100%">
                    <thead>
                        <tr>
                            <td>Referral</td>
                            <td>Deskripsi Laporan</td>
                            <td>Waktu Laporan</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#title-label').html('Antrean Laporan')
</script>