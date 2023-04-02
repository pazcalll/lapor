var dt = null
var opds = []

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

function incomingReportDatatable(storageLink) {
    let format = function (d) {
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
            url: apiBaseUrl + "/user/admin/unaccepted-reports",
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
            { width: '15%', targets: 4 },
            { width: '10%', targets: 5 },
            { width: '10%', targets: 6 },
            { width: '10%', targets: 7 },
            { width: '15%', targets: 8 },
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
                data: null,
                render: function (data, type, full, meta) {
                    let select = `
                        <select class="form-control opd-select" onchange="confirmationOPD('${data.referral}', this)">
                            <option value="default" selected disabled>Pilih OPD</option>
                    `
                    opds.forEach((opd, _index) => {
                        select += `<option value="${opd.id}">${opd.name}</option>`
                    });
                    select += `</select>`
                    return select
                }
            },
            {
                data: 'issue',
            },
            {
                data: null,
                render: function (data, type, full, meta) {
                    let dataFiles = ``
                    data.report_file.forEach((ele, _index) => {
                        dataFiles += `data-file${(_index + 1)}="${ele.proof_file}" `
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
                render: function (data, type, full, meta) {
                    let dataFiles = ``
                    data.report_file.forEach((ele, _index) => {
                        dataFiles += `data-file${(_index + 1)}="${ele.proof_file}" `
                    })
                    return `
                        <button data-backdrop="false" data-toggle="modal" data-target="#prosesModal" type="button" class="btn btn-success btn-process" data-referral="${data.referral}">Proses</button>
                        <a data-referral="${data.referral}" data-backdrop="false" data-toggle="modal" data-target="#rejectModal" class="btn btn-danger btn-reject-report" href="javascript:void(0)">Tolak Laporan</a>
                        <button 
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#editDetailModal" 
                            type="button" 
                            class="btn btn-warning btn-detail" 
                            data-issue="${data.issue}" 
                            data-facility="${data.facility.name}" 
                            data-street="${data.report_location.street}" 
                            data-rt="${data.report_location.rt}" 
                            data-rw="${data.report_location.rw}" 
                            data-village="${data.report_location.village}" 
                            data-sub_district="${data.report_location.sub_district}" 
                            data-reporter="${data.reporter.name}" 
                            data-referral="${data.referral}">
                                Ubah Data Laporan
                        </button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('#incoming_report tbody').unbind()
            $('#confirmOPDModal').unbind()
            $('.btn-process').unbind()
            $('.btn-detail').unbind()
            $('.btn-proof').unbind()
            $('.btn-reject-report').unbind()
            $('#incoming_report tbody').on('click', 'tr td.dt-control', function () {
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
            $('#confirmOPDModal').on('hidden.bs.modal', function () {
                $('.opd-select').val('default')
            })
            $('.btn-process').on('click', function () {
                $('.referral_modal').html($(this).data('referral'))
                $('#referral').val($(this).data('referral'))
            })
            $('.btn-detail').on('click', function () {
                $('.referral_modal').html($(this).data('referral'))
                $('#reporter').val($(this).data('reporter'))
                $('#referral_detail').val($(this).data('referral'))
                $('#street').val($(this).data('street'))
                $('#rt').val($(this).data('rt'))
                $('#rw').val($(this).data('rw'))
                $('#village').val($(this).data('village'))
                $('#sub_district').val($(this).data('sub_district'))
                $('#issue').val($(this).data('issue'))
                $('#additional').val($(this).data('additional'))
            })
            $('.btn-proof').on('click', function () {
                $('.referral_proof').html($(this).data('referral'))
                let proofs = ``
                let i = 0
                while (true) {
                    i += 1
                    if ($(this).data(`file${i}`) === undefined) {
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
}

function getOpds() {
    $.ajax({
        url: apiBaseUrl + "/user/admin/opds",
        type: "GET",
        success: (res) => {
            options = `<option value='default' disabled hidden selected>Pilih OPD</option>`
            opds = []
            res.data.forEach((opd, _index) => {
                opds.push({
                    id: opd.id,
                    name: opd.name
                })
                options += `<option value='${opd.id}'>` + opd.name + "</option>"
            });
            $('#opd').html(options)
        },
        error: (err) => {
            console.log(err)
        }
    })
}

function confirmationOPD(referral, ele) {
    $('.referral_confirmOPD').html(referral)
    $('#confirmOPDModal').modal('show')

    $('#confirmOPDModal #referral').val(referral)
    for (let i = 0; i < opds.length; i++) {
        if (opds[i].id == ele.value) {
            $('.opd_spill').html(opds[i].name)
        }
    }
    $('#confirmOPDModal #opd').val(ele.value)
    console.log($('#confirmOPDModal #opd'))
    // console.log($('#confirmOPDModal #referral').val())
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
    let elements = e.target.elements
    let fd = new FormData()
    fd.append('referral', elements.referral.value)
    fd.append('opd', elements.opd.value)
    fd.append('deadline_at', elements.deadline_at.value)
    fd.append('additional', elements.additional.value)
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
        },
        complete: () => {
            $('.opd-select').val('default')
        }
    })
}

function editReportDetail(e) {
    e.preventDefault()
    let elements = e.target.elements
    $.ajax({
        url: apiBaseUrl + "/user/admin/edit-report",
        type: "PUT",
        data: {
            referral: elements.referral_detail.value,
            street: elements.street.value,
            rt: elements.rt.value,
            rw: elements.rw.value,
            village: elements.village.value,
            sub_district: elements.sub_district.value,
            issue: elements.issue.value
        },
        beforeSend: () => {
            $(".modal-close").click()
        },
        success: (res) => {
            toastr.success("Data laporan telah diubah!")
        },
        error: (err) => {
            console.log(err)
            toastr.error("Data gagal diubah, mohon periksa kembali isian anda")
        },
        complete: () => {
            dt.ajax.reload()
        }
    })
}