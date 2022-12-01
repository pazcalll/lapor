let dt = null

function homePage() {
    $.ajax({
        url: webBaseUrl + '/admin/home-page',
        type: "GET",
        headers: {
            Authorization: 'bearer ' + localStorage.getItem('_token')
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


