var dt = null

// ===========================================HOME PAGE======================================
function homePage() {
    $.ajax({
        url: webBaseUrl + '/opd/home-page',
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#home").addClass('active')
            $("#content").html(`
                <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                    <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </span>
            `)
        },
        success: (res) => {
            $('#content').html(res)
        },
        error: (err) => {
            console.log(err)
            window.location.reload()
        }
    })
}
homePage()

function historyPage() {
    $.ajax({
        url: webBaseUrl + '/opd/history-page',
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#history").addClass('active')
            $("#content").html(`
                <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                    <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </span>
            `)
        },
        success: (res) => {
            $('#content').html(res)
        },
        error: (err) => {
            console.log(err)
            window.location.reload()
        }
    })
}

function logout() {
    $.ajax({
        url: apiBaseUrl + "/user/logout",
        type: "POST",
        headers: {
            Authorization: "bearer " + localStorage.getItem('_token')
        },
        success: (res) => {
            window.location.href = webBaseUrl + "/login"
        },
        error: (err) => {
            if (err.responseJSON.status == 400) {
                localStorage.setItem('_token', err.responseJSON._token)
                logout()
            }else {
                window.location.reload()
            }
        }
    })
}

function getIncomingAssignments() {
    dt = $('#incoming_assignment').DataTable({
        ajax: {
            url: apiBaseUrl+"/user/opd/incoming-assignments",
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
            { width: '10%', targets: 0 },
            { width: '10%', targets: 1 },
            { width: '10%', targets: 2 },
            { width: '15%', targets: 3 },
            { width: '25%', targets: 4 },
            { width: '15%', targets: 5 },
            { width: '5%', targets: 6 },
            { width: '20%', targets: 7 },
        ],
        columns: [
            { 
                data: null,
                render: function (data, type, full, meta) {  
                    return `${data.report.referral}`
                }
            },
            {
                data: null,
                render: function (data, type, full, meta) {  
                    return `${data.report.reporter.name}`
                }
            },
            {
                data: null,
                render: function (data, type, full, meta) {
                    return `${data.report.created_at}`
                }
            },
            {
                data: 'created_at',
            },
            {
                data: null,
                render: function (data, type, full, meta) {  
                    return `${data.report.facility.name}`
                }
            },
            {
                data: 'report.issue',
            },
            {
                data: 'report.status',
            },
            {
                data: null,
                render: function (data, type, full, meta) {  
                    let dataFiles = ``
                    data.report.report_file.forEach((ele, _index) => {
                        dataFiles += `data-file${(_index+1)}="${ele.proof_file}" `
                    })
                    return `
                        <button data-backdrop="false" data-toggle="modal" data-target="#proofModal" type="button" class="btn btn-warning btn-proof" data-referral="${data.report.referral}" ${dataFiles}>Bukti Laporan</button>
                    `
                }
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    console.log(data)
                    return `
                        <button 
                            data-referral="${data.report.referral}"
                            data-reporter="${data.report.reporter.name}"
                            data-issue="${data.report.issue}"
                            data-opd="${data.opd.name}"
                            data-additional="${data.additional}"
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#detailModal" 
                            type="button" 
                            class="btn btn-info btn-detail-assignment"
                            data-street="${data.report.report_location.street}"
                            data-rt="${data.report.report_location.rt}"
                            data-rw="${data.report.report_location.rw}"
                            data-village="${data.report.report_location.village}"
                            data-sub_district="${data.report.report_location.sub_district}"
                        >
                            Detail
                        </button>
                        <button 
                            data-referral="${data.report.referral}"
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#finishModal"
                            class="btn btn-success btn-finish-assignment" 
                        >
                            Selesaikan
                        </button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-detail-assignment').on('click', function () {  
                $(".referral_modal").html($(this).data('referral'))
                $("#opd_detail").val($(this).data('opd'))
                $("#reporter_detail").val($(this).data('reporter'))
                $("#issue_detail").val($(this).data('issue'))
                $("#additional_detail").val($(this).data('additional'))

                $('#street').val($(this).data('street'))
                $('#rt').val($(this).data('rt')) 
                $('#rw').val($(this).data('rw'))
                $('#village').val($(this).data('village'))
                $('#sub_district').val($(this).data('sub_district'))
            })
            $('.btn-finish-assignment').on('click', function () {  
                $("#referral_finish").val($(this).data('referral'))
                $(".referral_modal_finish").html($(this).data('referral'))
            })
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
}