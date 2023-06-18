<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <div class="col-lg-12">
            <table class="table table-striped table-borderless" style="width: 100%">
                <thead>
                    <tr>
                        <td>No. Pelaporan</td>
                        <td>Waktu Pelaporan</td>
                        <td>Fasilitas</td>
                        <td>OPD</td>
                        <td>Deskripsi Laporan</td>
                        <td>Dokumen Pendukung / Bukti</td>
                        <td>Status</td>
                        <td>Buat Feedback</td>
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


<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambahkan Feedback</h5>
                <button type="button" class="btn-close close modal-close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="addFeedback(event)">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>Referral : </span><span class="referral_feedback"></span>
                                <input type="hidden" name="referral_feedback" id="referral_feedback">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional">Isi feedback: </label>
                                <textarea class="form-control" name="feedback" id="feedback" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rating">Tingkat Kepuasan: </label>
                                <div class="rating-container">
                                    <input id="rating" name="rating" type="text" class="kv-uni-star rating-loading" data-size="md" title="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="seeFeedbackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Isi Feedback</h5>
                <button type="button" class="btn-close close modal-close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>Referral : </span><span class="see-referral-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional">Isi feedback: </label>
                                <textarea class="form-control" disabled id="see-feedback" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rating">Tingkat Kepuasan: </label>
                                <div class="see-rating-feedback-container">
                                    {{-- <input id="see-rating-feedback" type="text" class="rating-loading" data-size="md" title=""> --}}
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
</div>

<script>
    $('#title-label').html("Riwayat Laporan")
    $('.kv-uni-star').rating({
        theme: 'krajee-uni',
        filledStar: '&#x2605;',
        emptyStar: '&#x2606;',
        step: 1,
        showCaption: false,
        clearButton: '<button type="button" class="btn btn-danger">Kosongkan Bintang</button>',
        clearButtonTitle: 'Bersihkan'
    });
    $('.rating,.kv-uni-star').on('change', function () {
        console.log('Rating selected: ' + $(this).val());
    });
</script>