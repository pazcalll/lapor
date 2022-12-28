
function reportHistoryPage() {
    $.ajax({
        url: webBaseUrl + '/customer/report-history-page',
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
            $('#history').addClass('active')
        },
        success: (res) => {
            $('#content').html(res)
            
            dt = $('.table').DataTable({
                ajax: {
                    url: apiBaseUrl + '/user/customer/reports',
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
                    { width: '10%', targets: 3 },
                    { width: '20%', targets: 4 },
                    { width: '10%', targets: 5 },
                    { width: '10%', targets: 6 },
                    { width: '10%', targets: 7 }
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
                        data: null,
                        render: function(data, type, full, meta){
                            if (data.status == "DITOLAK") {
                                return ''
                            }else {
                                return data.assignment.opd.name
                            }
                        }
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
                            return `
                                <button data-backdrop="false" data-toggle="modal" data-target="#proofModal" type="button" class="btn btn-success btn-proof" data-referral="${data.referral}" ${dataFiles}>Bukti</button>
                            `
                        }
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            let btn = ''
                            console.log(data.feedback != null)
                            if (data.status == "LAPORAN TELAH SELESAI" && data.feedback == null) {
                                btn += `<button data-referral="${data.referral}" data-backdrop="false" data-toggle="modal" data-target="#feedbackModal" type="button" class="btn btn-primary btn-add-feedback">Feedback</button>`
                            }else if(data.status == "LAPORAN TELAH SELESAI" && data.feedback != null){
                                btn = 'Feedback telah diberikan'
                            }else if(data.status == "DITOLAK") {
                                btn = 'Tidak bisa memberi feedback ke laporan yang ditolak'
                            }else {
                                btn = 'Menunggu proses selesai'
                            }
                            return btn
                        }
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
                    $('.btn-add-feedback').on('click', function () {  
                        $('#referral_feedback').val($(this).data('referral'))
                        $('.referral_feedback').html($(this).data('referral'))
                    })
                }
            })
        }
    })
}

function addFeedback(e) {
    e.preventDefault()
    let elements = e.target.elements
    // console.log(elements.rating.value)
    $.ajax({
        url: apiBaseUrl + '/user/customer/feedback',
        type: "POST",
        data: {
            referral: elements.referral_feedback.value,
            feedback: elements.feedback.value,
            rating: elements.rating.value
        },
        success: (res) => {
            toastr.success('Feedback telah dikirim!')
            dt.ajax.reload()
            $('textarea').val('')
            $('.modal-close').click()
        },
        error: (err) => {
            toastr.error('Feedback gagal dikirim, mohon periksa ulang form anda atau hubungi pihak terkait!')
            console.log(err)
        }
    })
}