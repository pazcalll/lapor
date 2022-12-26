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
            { width: '10%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '10%', targets: 3 },
            { width: '20%', targets: 4 },
            { width: '10%', targets: 5 },
            { width: '10%', targets: 6 },
            { width: '20%', targets: 7 },
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
                    return `
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
            },
            {
                data: 'status',
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

