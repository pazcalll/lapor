var dt = null

function homePage() {
    $.ajax({
        url: webBaseUrl + '/officer/home-page',
        type: "GET",
        headers: {
            Authorization: 'bearer ' + localStorage.getItem('_token')
        },
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#home").addClass('active')
        },
        success: (res) => {
            // let mainjs = document.createElement('script');
            // mainjs.setAttribute('type', 'text/javascript');
            // mainjs.setAttribute('src', webBaseUrl+'/js/main.js');
            // document.head.appendChild(mainjs);
            $('#content').html(res)
        },
        error: (err) => {
            console.log(err)
            window.location.reload()
        }
    })
}
homePage()

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
            url: apiBaseUrl+"/user/officer/incoming-assignments",
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
            { width: '20%', targets: 1 },
            { width: '20%', targets: 2 },
            { width: '25%', targets: 3 },
            { width: '25%', targets: 4 },
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
                render: function(data, type, full, meta) {
                    console.log(data)
                    return `
                        <button 
                            data-referral="${data.report.referral}"
                            data-reporter="${data.report.reporter.name}"
                            data-location="${data.report.location}"
                            data-issue="${data.report.issue}"
                            data-officer="${data.officer.name}"
                            data-additional="${data.additional}"
                            data-bs-backdrop="false" 
                            data-bs-toggle="modal" 
                            data-bs-target="#detailModal" 
                            type="button" 
                            class="btn btn-info btn-detail-assignment"
                        >
                            Detail
                        </button>
                        <button 
                            data-referral="${data.report.referral}"
                            data-bs-backdrop="false" 
                            data-bs-toggle="modal" 
                            data-bs-target="#finishModal"
                            class="btn btn-success btn-finish-assignment" 
                        >
                            Selesai
                        </button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-detail-assignment').on('click', function () {  
                $(".referral_modal").val($(this).data('referral'))
                $("#officer_detail").val($(this).data('officer'))
                $("#reporter_detail").val($(this).data('reporter'))
                $("#location_detail").val($(this).data('location'))
                $("#issue_detail").val($(this).data('issue'))
                $("#additional_detail").val($(this).data('additional'))
            })
            $('.btn-finish-assignment').on('click', function () {  
                $("#referral_finish").val($(this).data('referral'))
                $(".referral_modal_finish").html($(this).data('referral'))
            })
        }
    })
}

function finishAssignment(e) {
    e.preventDefault()
    let fd = new FormData()
    fd.append('referral', $('#referral_finish').val())
    fd.append('file_finish', $('#file_finish')[0].files[0])
    console.log('asdf')
    $.ajax({
        url: apiBaseUrl+"/user/officer/finish-assignment",
        type: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: (res) => {
            $('.modal-close').click()
            console.log(res)
            dt.ajax.reload()
        },
        error: (err) => {
            console.log(err)
        }
    })
}