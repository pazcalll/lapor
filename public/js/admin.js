let dt = null

function homePage() {
    $.ajax({
        url: webBaseUrl + '/admin/home-page',
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

function incomingReportDatatable() {
    dt = $('#incoming_report').DataTable({
        ajax: {
            url: apiBaseUrl+"/user/admin/unaccepted-reports",
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
                $('.referral_modal').html($(this).data('referral'))
                $('#referral').val($(this).data('referral'))
            })
            $.ajax({
                url: apiBaseUrl + "/user/get-facilities",
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
                    console.log(err)
                    window.location.reload()
                }
            })
        }
    })
}

function getOfficers() {
    $.ajax({
        url: apiBaseUrl + "/user/admin/officers",
        type: "GET",
        success: (res) => {
            console.log(res)
            options = `<option disabled hidden selected>Pilih Pegawai</option>`
            res.data.forEach((item, _index) => {
                options += `<option value='${item.id}'>`+item.name+"</option>"
            });
            $('#officer').html(options)
        },
        error: (err) => {
            console.log(err)
        }
    })
}

function processReport(e) {
    e.preventDefault()
    let fd = new FormData()
    fd.append('referral', $('#referral').val())
    fd.append('officer', $('#officer').val())
    fd.append('additional', $('#additional').val())
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    $('.modal-close').click()

    // $('#prosesModal').modal('hide')
    $.ajax({
        url: apiBaseUrl + "/user/admin/process-report",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        beforeSend: () => {
            $('#referral').val('')
            $('#officer').val('Pilih Pegawai')
            $('#additional').val('')
            dt.ajax.reload()
        },
        success: (res) => {
            toastr.success('Laporan berhasil disetujui')
        },
        error: (err) => {
            toastr.error('Mohon Periksa ulang isian anda')
            console.log(err)
        }
    })
}



// ----------   LAPORAN DIPROSES-----------------------


function processPage() {
    $.ajax({
        url: webBaseUrl + '/admin/process-page',
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#process").addClass('active')
        },
        success: (res) => {
            $("#content").html(res)
        },
        error: (err) => {
            console.log(err)
            console.log(err.responseJSON)
            console.log(err.responseText)
        }
    })
}

function getAcceptedReports(storageLink) {
    console.log(storageLink)
    dt = $('#inprocess_report').DataTable({
        ajax: {
            url: apiBaseUrl+"/user/admin/accepted-reports",
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
            { width: '15%', targets: 0 },
            { width: '30%', targets: 1 },
            { width: '25%', targets: 2 },
            { width: '30%', targets: 3 },
        ],
        columns: [
            {
                data: 'referral',
            },
            {
                data: 'assignment.officer.name',
            },
            {
                data: 'assignment.created_at',
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    console.log(data)
                    return `
                        <button data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#detailModal" type="button" class="btn btn-info" data-referral="${data.referral}"><i class="bi bi-sticky"></i> Detail</button>
                        <a class="btn btn-info" target="_blank" href="${storageLink + "/proof/" + data.proof_file}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-columns-reverse" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 .5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10A.5.5 0 0 1 4 .5Zm-4 2A.5.5 0 0 1 .5 2h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 4h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 8h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Z"/>
                            </svg> 
                            Lihat Bukti
                        </a>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-process').on('click', function () {  
                $('.referral_modal').html($(this).data('referral'))
                $('#referral').val($(this).data('referral'))
            })
            $.ajax({
                url: apiBaseUrl + "/user/get-facilities",
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
                    console.log(err)
                    window.location.reload()
                }
            })
        }
    })
}