<!-- Header Start -->
<div class="container-fluid hero-header bg-light py-5 mb-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <h1 class="display-4 mb-3">Laporan Masuk</h1>
            <table id="incoming_report" class="table table-striped table-borderless" style="width: 100%">
                <thead>
                    <tr>
                        <td>Referral</td>
                        <td>Deskripsi Laporan</td>
                        <td>Waktu Laporan</td>
                        <td>Status</td>
                        <td>Tindakan</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('#incoming_report').DataTable({
        ajax: {
            url: "{{ route('getUnacceptedReport') }}",
            type: "GET",
            cache: true,
            headers: headers
        },
        lengthChange: false,
        scrollX: true,
        language: {
            url: webBaseUrl + "/json/datatable-indonesia.json"
        },
        columnDefs: [
            { width: '5%', targets: 0 },
            { width: '40%', targets: 1 },
            { width: '20%', targets: 2 },
            { width: '15%', targets: 3 },
            { width: '20%', targets: 4 },
        ],
        columns: [
            {
                data: 'referral',
            },
            {
                data: 'issue',
            },
            {
                data: 'created_at',
            },
            {
                data: 'status'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    console.log(data)
                    return `
                        <button data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#prosesModal" type="button" class="btn btn-success btn-process" data-referral="${data.referral}">Proses</button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-process').on('click', function () {  
                console.log($(this).data('referral'))
                $('.referral_modal').html($(this).data('referral'))
            })
            $.ajax({
                url: "{{ route('getFacilities') }}",
                type: "GET",
                success: (res) => {
                    let facilityHTML = '<option value="" selected disabled hidden>Pilih Fasilitas</option>'
                    res.forEach(facility => {
                        facilityHTML += `
                            <option value="${facility.id}">${facility.name}</option>
                        `
                    });
                    $('#facility').html(facilityHTML)
                },
                error: (err) => {
                    window.location.reload()
                }
            })
        }
    })
</script>
<!-- Header End -->

<!-- Modal -->
<div class="modal fade" id="prosesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="makeReport">
                @method("POST")
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Referral : </span><span class="referral_modal"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <select name="officer" id="officer" class="form-select" aria-placeholder="">
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control" style="height: 100px" name="additional" id="additional" placeholder="Informasi Tambahan" cols="30" rows="50"></textarea>
                                <label for="additional">Informasi Tambahan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Buat Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
        class="bi bi-arrow-up"></i></a>

<script>
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
    $('')
</script>