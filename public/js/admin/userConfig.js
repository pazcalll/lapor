
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