var dt = null

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

function incomingReportDatatable(storageLink) {
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
            { width: '15%', targets: 0 },
            { width: '40%', targets: 1 },
            { width: '20%', targets: 2 },
            { width: '25%', targets: 3 },
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
                data: null,
                render: function(data, type, full, meta) {
                    return `
                        <button data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#prosesModal" type="button" class="btn btn-success btn-process" data-referral="${data.referral}">Proses</button>
                        <a data-href="${data.proof_file}" class="btn btn-info btn-proof" href="javascript:void(0)">Lihat Bukti</a>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-process').on('click', function () {
                $('.referral_modal').html($(this).data('referral'))
                $('#referral').val($(this).data('referral'))
            })
            $('.btn-proof').on('click', function () {  
                window.open($(this).data('href'), '_blank');
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
            options = `<option disabled hidden selected>Pilih Pegawai</option>`
            res.data.forEach((officer, _index) => {
                options += `<option value='${officer.id}'>`+officer.name+"</option>"
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

    // $('#prosesModal').modal('hide')
    $.ajax({
        url: apiBaseUrl + "/user/admin/process-report",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        beforeSend: () => {
            $('.report-form').addClass('visually-hidden')
            $('.modal-close').click()
            $('#referral').val('')
            $('#officer').val('Pilih Pegawai')
            $('#additional').val('')
        },
        success: (res) => {
            $('.report-form').addClass('visually-hidden')
            toastr.success('Laporan berhasil disetujui')
            dt.ajax.reload()
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
            $("#content").html(`
                <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                    <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </span>
            `)
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
                    return `
                        <button data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#detailModal" type="button" class="btn btn-info btn-detail" data-issue="${data.issue}" data-facility="${data.facility.name}" data-officer="${data.assignment.officer.name}" data-location="${data.location}" data-reporter="${data.reporter.name}" data-additional="${data.assignment.additional}" data-referral="${data.referral}"><i class="bi bi-sticky"></i> Detail</button>
                        <button class="btn btn-warning btn-proof" data-item="${data.proof_file}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-columns-reverse" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 .5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10A.5.5 0 0 1 4 .5Zm-4 2A.5.5 0 0 1 .5 2h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 4h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 8h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Z"/>
                            </svg> 
                            Lihat Bukti
                        </button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-proof').on('click', function () {  
                window.open($(this).data('item'), '_blank');
            })
            $('.btn-detail').on('click', function () {  
                $('.referral_modal').html($(this).data('referral'))
                $('#officer').val($(this).data('officer'))
                $('#reporter').val($(this).data('reporter'))
                $('#location').val($(this).data('location'))
                $('#issue').val($(this).data('issue'))
                $('#additional').val($(this).data('additional'))
            })
            $.ajax({
                url: apiBaseUrl + "/user/get-facilities",
                type: "GET",
                success: (res) => {
                    let facilityHTML = '<option value="0" selected disabled hidden>Pilih Fasilitas</option>'
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

// -------------------------LAPORAN SELESAI----------------------------------
function finishedPage() {
    $.ajax({
        url: webBaseUrl+"/admin/finished-page",
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#finished").addClass('active')
            $("#content").html(`
                <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                    <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </span>
            `)
        },
        success: (res) => {
            $("#content").html(res)
        },
        error: (err) => {
            console.log(err)
        }
    })
}

function getFinishedReports(storageLink) {
    dt = $('#finished_report').DataTable({
        ajax: {
            url: apiBaseUrl+"/user/admin/finished-reports",
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
            { width: '25%', targets: 1 },
            { width: '20%', targets: 2 },
            { width: '20%', targets: 3 },
            { width: '25%', targets: 4 },
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
                data: 'assignment.finished_at',
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `
                        <button data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#detailModal" type="button" class="btn btn-info btn-detail" data-issue="${data.issue}" data-facility="${data.facility.name}" data-officer="${data.assignment.officer.name}" data-location="${data.location}" data-reporter="${data.reporter.name}" data-additional="${data.assignment.additional}" data-referral="${data.referral}"><i class="bi bi-sticky"></i> Detail</button>
                        <button class="btn btn-warning btn-proof" data-item="${data.proof_file}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-columns-reverse" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 .5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10A.5.5 0 0 1 4 .5Zm-4 2A.5.5 0 0 1 .5 2h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 4h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 8h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Z"/>
                            </svg> 
                            Bukti Pelapor
                        </button>
                        <button class="btn btn-success btn-proof-finish" data-item="${data.assignment.file_finish}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-columns-reverse" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 .5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10A.5.5 0 0 1 4 .5Zm-4 2A.5.5 0 0 1 .5 2h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 4h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 8h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Z"/>
                            </svg> 
                            Bukti Selesai
                        </button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-proof').on('click', function () {  
                window.open($(this).data('item'), '_blank');
            })
            $('.btn-proof-finish').on('click', function () {  
                window.open($(this).data('item'), '_blank');
            })
            $('.btn-detail').on('click', function () {  
                $('.referral_modal').html($(this).data('referral'))
                $('#officer').val($(this).data('officer'))
                $('#reporter').val($(this).data('reporter'))
                $('#location').val($(this).data('location'))
                $('#issue').val($(this).data('issue'))
                $('#additional').val($(this).data('additional'))
            })
        }
    })
}

// -----------------------------    USER CONFIG -----------------------------

function configPage() {
    $.ajax({
        url: webBaseUrl + '/admin/config-page',
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
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

function userTable() {
    dt = $('#user_table').DataTable({
        ajax: {
            url: apiBaseUrl+"/user/admin/non-admin-users",
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
            { width: '20%', targets: 0 },
            { width: '10%', targets: 1 },
            { width: '10%', targets: 2 },
            { width: '10%', targets: 3 },
            { width: '25%', targets: 4 },
            { width: '25%', targets: 5 },
        ],
        columns: [
            {
                data: 'name',
            },
            {
                data: 'username',
            },
            {
                data: 'role',
            },
            {
                data: 'phone',
            },
            {
                data: 'address',
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `
                        <button 
                            data-bs-backdrop="false" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserModal" 
                            type="button" 
                            class="btn btn-info btn-edit-user" 
                            data-username="${data.username}"
                            data-name="${data.name}"
                            data-role="${data.role}"
                        >
                            <i class="bi bi-pencil-square"></i> 
                            Edit
                        </button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-edit-user').on('click', function () {  
                $('.username').html($(this).data('username'))
                $('#name').val($(this).data('name'))
                $('#username').val($(this).data('username'))
                $('#role').val($(this).data('role'))
            })
        }
    })
}

function getEnumUser() {
    $.ajax({
        url: apiBaseUrl + "/user/admin/enum-user",
        type: "GET", 
        success: (res) => {
            options = `<option disabled hidden selected>Pilih Role</option>`
            res.forEach((item, _index) => {
                options += `<option value='${item}'>`+item+"</option>"
            });
            $('#role').html(options)
        },
        error: (err) => {
            console.log(err)
        }
    })
}

function editUser(e) {
    e.preventDefault()
    let fd = new FormData()
    fd.append('username', $('#username').val())
    fd.append('role', $('#role').val())
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    $('.modal-close').click()

    $.ajax({
        url: apiBaseUrl + "/user/admin/edit-user",
        type: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: (res) => {
            toastr.success("Role pengguna telah diubah!")
            dt.ajax.reload()
        },
        error: (err) => {
            console.log(err)
            toastr.error("Terjadi kesalahan")
        }
    })
}
// ------------------------------- FACILITIES-----------------------

function facilitiesPage() {
    $.ajax({
        url: webBaseUrl + "/admin/facilities-page",
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
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
        }
    })
}

function getFacilitiesDatatable() {
    dt = $('#facilities_table').DataTable({
        ajax : {
            url: apiBaseUrl + "/user/admin/facilities-datatable",
            type: "GET",
            headers: headers
        },
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Tambah Fasilitas',
                className: "btn btn-success btn-add-facility-modal",
                attr:  {
                    "data-bs-backdrop": 'false',
                    "data-bs-toggle": 'modal',
                    "data-bs-target": "#addFacilityModal"
                }
            }
        ],
        lengthChange: false,
        scrollX: true,
        language: {
            url: webBaseUrl + "/json/datatable-indonesia.json"
        },
        columnDefs: [
            { width: '20%', targets: 0 },
            { width: '25%', targets: 1 },
            { width: '25%', targets: 2 },
            { width: '30%', targets: 3 },
        ],
        columns: [
            {
                data: 'name',
            },
            {
                data: 'created_at',
            },
            {
                data: 'updated_at',
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `
                        <button 
                            data-bs-backdrop="false" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editFacilityModal" 
                            data-name=${data.name}
                            type="button" 
                            class="btn btn-info btn-edit-facility" 
                        >
                            <i class="bi bi-pencil-square"></i> 
                            Edit
                        </button>
                        <button
                            data-bs-backdrop="false" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteFacilityModal" 
                            data-delete="${data.name}"
                            class="btn btn-danger btn-delete-facility"
                        >
                            Hapus
                        </button>
                    `
                }
            }
        ],
        drawCallback: () => {
            $('.btn-edit-facility').on('click', function () {  
                $('.facility_name_modal_edit').html($(this).data('name'))
                $('#facility_name_old').val($(this).data('name'))
            })
            $(".btn-delete-facility").on("click", function () {  
                $('.facility_name_modal_delete').html($(this).data('delete'))
                $('#facility_name_delete').val($(this).data('delete'))
            })
        }
    })
}

function addFacility(e) {
    e.preventDefault()
    let fd = new FormData()
    fd.append('name', $('#facility_name_add').val())
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    $.ajax({
        url: apiBaseUrl + "/user/admin/facility",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        beforeSend: () => {
            $(".modal-close").click()
            $('.facility_name_modal_edit').val("")
            $('#facility_name_old').val("")
            $('#facility_name_new').val("")
            toastr.warning("Mohon tunggu")
        },
        success: (res) => {
            console.log(res)
            toastr.remove()
            toastr.success("Penambahan fasilitas berhasil")
            dt.ajax.reload()
        },
        error: (err) => {
            console.log(err)
            toastr.error("Penambahan fasilitas gagal")
        }
    })
}

function editFacility(e) {
    let name_old = $('#facility_name_old').val()
    let name_new = $('#facility_name_new').val()
    let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    $.ajax({
        url: apiBaseUrl + "/user/admin/facility",
        type: "PATCH",
        data: {
            name_old: name_old,
            name_new: name_new,
            _token: _token,
        },
        beforeSend: () => {
            $(".modal-close").click()
            $('#facility_name_old').val("")
            $('#facility_name_new').val("")
            toastr.warning("Mohon tunggu")
        },
        success: (res) => {
            console.log(res)
            toastr.remove()
            toastr.success("Perubahan fasilitas berhasil")
            dt.ajax.reload()
        },
        error: (err) => {
            console.log(err)
            toastr.error("Perubahan fasilitas gagal")
        }
    })
}

function deleteFacility(e) {
    e.preventDefault()
    let name_delete = $('#facility_name_delete').val()
    let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    $.ajax({
        url: apiBaseUrl + "/user/admin/facility",
        type: "DELETE",
        data: {
            name_delete: name_delete,
            _token: _token,
        },
        beforeSend: () => {
            $(".modal-close").click()
            $('#facility_name_delete').val("")
            toastr.warning("Mohon tunggu")
        },
        success: (res) => {
            toastr.remove()
            toastr.success("Penghapusan fasilitas berhasil")
            dt.ajax.reload()
        },
        error: (err) => {
            toastr.error("Penghapusan fasilitas gagal")
        }
    })
}