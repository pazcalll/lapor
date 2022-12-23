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
            // console.log(err)
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
    let format = function(d) {
        // `d` is the original data object for the row
        return (
            `
            <div class="d-flex justify-content-around">
                <table cellpadding="3" cellspacing="0" border="0">
                    <tr>
                        <td>Jalan</td>
                        <td>:</td>
                        <td>${d.street}</td>
                    </tr>
                    <tr>
                        <td>RT</td>
                        <td>:</td>
                        <td>${d.rt}</td>
                    </tr>
                    <tr>
                        <td>RW</td>
                        <td>:</td>
                        <td>${d.rw}</td>
                    </tr>
                    <tr>
                        <td>Desa</td>
                        <td>:</td>
                        <td>${d.village}</td>
                    </tr>
                    <tr>
                        <td>Kecamatan</td>
                        <td>:</td>
                        <td>${d.sub_district}</td>
                    </tr>
                </table>
            </div>
            `
        );
    }
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
            { width: '15%', targets: 1 },
            { width: '30%', targets: 2 },
            { width: '20%', targets: 3 },
            { width: '30%', targets: 4 },
        ],
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '<button type="button" class="btn btn-info">&plus;</button>',
            },
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
                    let dataFiles = ``
                    data.report_file.forEach((ele, _index) => {
                        dataFiles += `data-file${(_index+1)}="${ele.proof_file}" `
                    })
                    return `
                        <button data-backdrop="false" data-toggle="modal" data-target="#prosesModal" type="button" class="btn btn-success btn-process" data-referral="${data.referral}">Proses</button>
                        <a data-referral="${data.referral}" data-backdrop="false" data-toggle="modal" data-target="#proofModal" ${dataFiles} class="btn btn-info btn-proof" href="javascript:void(0)">Lihat Bukti</a>
                        <a data-referral="${data.referral}" data-backdrop="false" data-toggle="modal" data-target="#rejectModal" class="btn btn-danger btn-reject-report" href="javascript:void(0)">Tolak Laporan</a>
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
            $('.btn-reject-report').on('click', function () {  
                $('.referral_reject').html(`${$(this).data('referral')}`)
                $('#rejectReferral').val(`${$(this).data('referral')}`)
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
    $('#incoming_report tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = dt.row(tr);
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
            
            $(this).html('<button type="button" class="btn btn-info">&plus;</button>')
        } else {
            // Open this row
            row.child(format(row.data().report_location)).show();
            tr.addClass('shown');

            $(this).html('<button type="button" class="btn btn-danger">&minus;</button>')
        }
    });
}

function getOpds() {
    $.ajax({
        url: apiBaseUrl + "/user/admin/opds",
        type: "GET",
        success: (res) => {
            options = `<option disabled hidden selected>Pilih OPD</option>`
            res.data.forEach((opd, _index) => {
                options += `<option value='${opd.id}'>`+opd.name+"</option>"
            });
            $('#opd').html(options)
        },
        error: (err) => {
            console.log(err)
        }
    })
}

function rejectReport(e) {
    e.preventDefault()
    let elements = e.target.elements
    $.ajax({
        url: apiBaseUrl + '/user/admin/reject-report',
        type: "PATCH",
        data: {
            referral: elements.rejectReferral.value
        },
        success: (res) => {
            toastr.success('Laporan telah ditolak')
            dt.ajax.reload()
            $('.referral_reject').html('');
            $('#rejectReferral').val('');
            $('.modal-close').click()
        },
        error: (err) => {
            // console.log(err)
            toastr.error('Maaf, terjadi masalah. Silakan coba lagi nanti!')
        }
    })
}

function processReport(e) {
    e.preventDefault()
    let fd = new FormData()
    fd.append('referral', $('#referral').val())
    fd.append('opd', $('#opd').val())
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
            $('#opd').val('Pilih Pegawai')
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
                data: 'assignment.opd.name',
            },
            {
                data: 'assignment.created_at',
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    let dataFiles = ``
                    data.report_file.forEach((ele, _index) => {
                        dataFiles += `data-file${(_index+1)}="${ele.proof_file}" `
                    })
                    return `
                        <button 
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#detailModal" 
                            type="button" 
                            class="btn btn-info btn-detail" 
                            data-issue="${data.issue}" 
                            data-facility="${data.facility.name}" 
                            data-opd="${data.assignment.opd.name}" 
                            data-street="${data.report_location.street}" 
                            data-rt="${data.report_location.rt}" 
                            data-rw="${data.report_location.rw}" 
                            data-village="${data.report_location.village}" 
                            data-sub_district="${data.report_location.sub_district}" 
                            data-reporter="${data.reporter.name}" 
                            data-additional="${data.assignment.additional}" 
                            data-referral="${data.referral}">
                                Detail
                        </button>
                        <button
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#proofModal" 
                            class="btn btn-warning btn-proof" 
                            data-referral="${data.referral}"
                            ${dataFiles}>
                                Lihat Bukti
                        </button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
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
            $('.btn-detail').on('click', function () {  
                $('.referral_modal').html($(this).data('referral'))
                $('#opd').val($(this).data('opd'))
                $('#reporter').val($(this).data('reporter'))
                $('#street').val($(this).data('street'))
                $('#rt').val($(this).data('rt'))
                $('#rw').val($(this).data('rw'))
                $('#village').val($(this).data('village'))
                $('#sub_district').val($(this).data('sub_district'))
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
            { width: '15%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '25%', targets: 3 },
            { width: '15%', targets: 4 },
            { width: '20%', targets: 5 },
            { width: '20%', targets: 6 },
            { width: '20%', targets: 7 },
        ],
        columns: [
            {
                data: 'referral',
            },
            {
                data: 'created_at',
            },
            {
                data: 'assignment.created_at',
            },
            {
                data: 'assignment.finished_at',
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
                    return `
                        <button data-backdrop="false" data-toggle="modal" data-target="#detailModal" type="button" class="btn btn-info btn-detail" data-issue="${data.issue}" data-facility="${data.facility.name}" data-opd="${data.assignment.opd.name}" data-location="${data.location}" data-reporter="${data.reporter.name}" data-additional="${data.assignment.additional}" data-referral="${data.referral}"><i class="bi bi-sticky"></i> Detail</button>
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
            },
            {
                data: 'status'
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
                $('#opd').val($(this).data('opd'))
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
            $('#addOpdForm').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    url: apiBaseUrl + "/user/admin/opd",
                    type: "POST",
                    data: $(this).serialize(),
                    success: (res) => {
                        $('.modal-close').click()
                        $('.form-control').val('')
                        toastr.success('OPD Telah Ditambahkan')
                    },
                    error: (err) => {
                        console.log(err)
                        toastr.error('Gagal menambahkan OPD, harap periksa lagi form anda atau coba lagi nanti!')
                    },
                    complete: () => {
                        dt.ajax.reload()
                    }
                })
            })
            $('#addCustomerForm').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    url: apiBaseUrl + "/user/admin/opd",
                    type: "POST",
                    data: $(this).serialize(),
                    success: (res) => {
                        $('.modal-close').click()
                        $('.form-control').val('')
                        toastr.success('OPD Telah Ditambahkan')
                    },
                    error: (err) => {
                        console.log(err)
                        toastr.error('Gagal menambahkan OPD, harap periksa lagi form anda atau coba lagi nanti!')
                    },
                    complete: () => {
                        dt.ajax.reload()
                    }
                })
            })
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
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Tambah Pelanggan',
                className: "btn btn-success btn-add-customer-modal",
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                },
                attr:  {
                    "data-backdrop": 'false',
                    "data-toggle": 'modal',
                    "data-target": "#addCustomerModal"
                }
            },
            {
                text: 'Tambah OPD',
                className: "btn btn-info btn-add-opd-modal",
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                },
                attr:  {
                    "data-backdrop": 'false',
                    "data-toggle": 'modal',
                    "data-target": "#addOpdModal"
                }
            }
        ],
        lengthChange: false,
        scrollX: true,
        language: {
            url: webBaseUrl + "/json/datatable-indonesia.json"
        },
        columnDefs: [
            { width: '30%', targets: 0 },
            { width: '15%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '15%', targets: 3 },
            { width: '25%', targets: 4 },
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
                data: null,
                render: function(data, type, full, meta) {
                    let btn = `
                        <button 
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#editUserModal" 
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
                    if (data.appointment_letter !== null) {
                        btn += `
                            <button 
                                onclick="window.open('${webBaseUrl}/storage/appointment_letter/${data.appointment_letter}', '_blank')"
                                class="btn btn-success"
                                type="button"
                            >
                                Cek SK
                            </button>
                        `
                    }
                    return btn
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


function addCustomer(e) {
    e.preventDefault()
    let elements = e.target.elements
    let authContent = ''
    let fd = new FormData();
    
    fd.append('username', elements.username.value)
    fd.append('password', elements.password.value)
    fd.append('name', elements.name.value)
    fd.append('phone', elements.phone.value)
    fd.append('street', elements.street.value)
    fd.append('rt', elements.rt.value)
    fd.append('rw', elements.rw.value)
    fd.append('village', elements.village.value)
    fd.append('sub_district', elements.sub_district.value)
    fd.append('appointment_letter', elements.appointment_letter.files[0])
    $.ajax({
        url: apiBaseUrl + '/user/admin/register-customer',
        type: "POST",
        contentType: false,
        processData: false,
        data: fd,
        success: (res) => {
            $('.modal-close').click()
            toastr.success('Sukses mendaftarkan akun')
            dt.ajax.reload()
        },
        error: function (err) {
            let errMsg = ''
            err.responseJSON.errors.forEach(msg => {
                errMsg += '<li>'+msg+'</li>'
            });
            $(document).ready(function () {  
                $('.errors').html(errMsg)
                $('.errors').css('display', 'block')
            })
            toastr.error('Gagal mendaftarkan akun, atribut dengan tanda * wajib diissi, harap cek ulang form anda!')
        },
        complete: function () {  
            $('.form-spinner').addClass('visually-hidden')
            $('.auth-content').html(authContent)
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
                    "data-backdrop": 'false',
                    "data-toggle": 'modal',
                    "data-target": "#addFacilityModal"
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
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#editFacilityModal" 
                            data-name=${data.name}
                            type="button" 
                            class="btn btn-info btn-edit-facility" 
                        >
                            <i class="bi bi-pencil-square"></i> 
                            Edit
                        </button>
                        <button
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#deleteFacilityModal" 
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