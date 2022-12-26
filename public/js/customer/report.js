// ==================================================== REPORT PAGE ===============================================
function reportPage() {  
    $.ajax({
        url: webBaseUrl + '/customer/report-page',
        type: "GET",
        headers: {
            Authorization: "bearer "+localStorage.getItem('_token')
        },
        beforeSend: () => {
            $('#content').html(`
            <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
            </span>
            `)
            $('.nav-item').removeClass('active')
            $('.dropdown-item').removeClass('active')
            $('#report').addClass('active')
        },
        success: (res) => {
            $('#content').html(res)
            
            getFacilities()
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
            dt = $('#report_queue').DataTable({
                ajax: {
                    url: apiBaseUrl + '/user/customer/unaccepted-reports',
                    headers: {
                        Authorization: "bearer " + localStorage.getItem('_token')
                    },
                    cache: true
                },
                lengthChange: false,
                scrollX: true,
                language: {
                    url: webBaseUrl + "/json/datatable-indonesia.json"
                },
                columnDefs: [
                    { width: '10%', targets: 0 },
                    { width: '15%', targets: 1 },
                    { width: '15%', targets: 2 },
                    { width: '25%', targets: 3 },
                    { width: '15%', targets: 4 },
                    { width: '20%', targets: 5 },
                ],
                columns: [
                    {
                        data: 'referral',
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'facility.name',
                    },
                    {
                        data: 'issue',
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            let dataFiles = ``
                            data.report_file.forEach((ele, _index) => {
                                dataFiles += `data-file${(_index+1)}="${ele.proof_file}" `
                            })
                            // let dataLocation = `
                            //     data-street="${data.report_location.street}"
                            //     data-rt="${data.report_location.rt}"
                            //     data-rw="${data.report_location.rw}"
                            //     data-village="${data.report_location.village}"
                            //     data-sub_district="${data.report_location.sub_district}"
                            // `
                            return `
                                <button data-backdrop="false" data-toggle="modal" data-target="#proofModal" type="button" class="btn btn-success btn-proof" data-referral="${data.referral}" ${dataFiles}>Bukti</button>
                            `
                        }
                    },
                    {
                        data: 'status'
                    }
                ],
                drawCallback: () => {
                    $('.btn-proof').on('click', function () {
                        $('.referral_proof').html($(this).data('referral'))
                        let proofs = ``
                        let i = 0
                        while (true) {
                            i += 1
                            if ($(this).data(`file${i}`)===undefined) {
                                break
                            }
                            proofs += `<a href="javascript:void(0)" onclick="window.open('${webBaseUrl}/storage/proof/${$(this).data(`file${i}`)}', '_blank')" class="btn btn-primary">Bukti ${i}</a>`
                        }
                        $('.proof-container').html(proofs)
                    })
                }
            })
        },
        error: (err) => {
            if (err.responseJSON.status == 400) {
                localStorage.setItem('_token', err.responseJSON._token)
                reportPage()
            }else {
                window.location.reload()
            }
        }
    })
}
