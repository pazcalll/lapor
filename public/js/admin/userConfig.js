var customerPosition = null
var gender = null
var dt = null
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
            if (customerPosition == null) getExistingCustomerPosition()
            else setCustomerPositionOption()

            if (gender == null) getExistingGender()
            else setGender('gender')

            $('.dropify').dropify({
                messages: {
                    'default': 'Masukkan bukti',
                    'replace': 'Masukkan ganti dengan bukti lain',
                    'remove': 'Hapus',
                    'error': 'Maaf, terjadi kesalahan.'
                },
                error: {
                    'fileSize': 'Ukuran terlalu besar (1 mb max).',
                }
            })
            $('#addOpdForm').on('submit', function (e) {
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
            $('#addCustomerForm').on('submit', function (e) {
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
            url: apiBaseUrl + "/user/admin/non-admin-users",
            type: "GET",
            cache: true,
            headers: headers
        },
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Tambah Pelanggan',
                className: "btn btn-success btn-add-customer-modal",
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary')
                },
                attr: {
                    "data-backdrop": 'false',
                    "data-toggle": 'modal',
                    "data-target": "#addCustomerModal"
                }
            },
            {
                text: 'Tambah OPD',
                className: "btn btn-info btn-add-opd-modal",
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary')
                },
                attr: {
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
            { width: '25%', targets: 0 },
            { width: '15%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '15%', targets: 3 },
            { width: '10%', targets: 4 },
            { width: '20%', targets: 5 },
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
                data: 'status',
            },
            {
                data: null,
                render: function (data, type, full, meta) {
                    let btn = ``

                    btn = `
                        <button 
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#changeStatusModal" 
                            type="button" 
                            class="btn btn-info btn-change-status" 
                            data-id="${data.id}"
                            data-username="${data.username}"
                            data-name="${data.name}"
                            data-status-to-be="ACTIVE"
                        >
                            <i class="zmdi zmdi-badge-check"></i>
                            Aktifkan
                        </button>

                    `
                    if (data.status == 'ACTIVE') {
                        btn = `
                            <button 
                                data-backdrop="false" 
                                data-toggle="modal" 
                                data-target="#changeStatusModal" 
                                type="button" 
                                class="btn btn-info btn-change-status" 
                                data-id="${data.id}"
                                data-username="${data.username}"
                                data-name="${data.name}"
                                data-status-to-be="INACTIVE"
                            >
                                <i class="zmdi zmdi-stop"></i>
                                Non-aktifkan
                            </button>
                        `
                    }
                    if (data.customer_position == null) {
                        btn += `
                            <button 
                                data-backdrop="false" 
                                data-toggle="modal" 
                                data-target="#editOpdModal" 
                                type="button" 
                                class="btn btn-info btn-edit-opd" 
                                data-id="${data.id}"
                                data-username="${data.username}"
                                data-name="${data.name}"
                                data-phone="${data.phone}"
                                data-street="${data.user_address_detail ? data.user_address_detail.street : '_'}"
                                data-rt="${data.user_address_detail ? data.user_address_detail.rt : '_'}"
                                data-rw="${data.user_address_detail ? data.user_address_detail.rw : '_'}"
                                data-village="${data.user_address_detail ? data.user_address_detail.village : '_'}"
                                data-sub_district="${data.user_address_detail ? data.user_address_detail.sub_district : '_'}"

                                data-role="${data.role}"
                            >
                                <i class="bi bi-pencil-square"></i> 
                                Edit
                            </button>
                        `
                    } else {
                        btn += `
                            <button 
                                data-backdrop="false" 
                                data-toggle="modal" 
                                data-target="#editCustomerModal" 
                                type="button" 
                                class="btn btn-info btn-edit-customer" 
                                data-id="${data.id}"
                                data-username="${data.username}"
                                data-name="${data.name}"
                                data-gender="${data.gender}"
                                data-appointment_letter="${data.appointment_letter}"
                                data-position="${data.customer_position.position}"
                                data-phone="${data.phone}"
                                data-street="${data.user_address_detail.street}"
                                data-rt="${data.user_address_detail.rt}"
                                data-rw="${data.user_address_detail.rw}"
                                data-village="${data.user_address_detail.village}"
                                data-sub_district="${data.user_address_detail.sub_district}"

                                data-role="${data.role}"
                            >
                                <i class="bi bi-pencil-square"></i> 
                                Edit
                            </button>
                        `
                    }

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
            $('.btn-change-status').on('click', function () {
                $('#changeUserStatusForm #status').val($(this).data('status-to-be'))
                $('#changeUserStatusForm #id').val($(this).data('id'))
                $('.username-strong').html($(this).data('username'))
                $('.name-strong').html($(this).data('name'))
                $('.status-strong').html($(this).data('status-to-be'))
            })
            $('.btn-edit-customer').on('click', function () {
                $('.dropify-clear').click()

                $('#id_customer').val($(this).data('id'))
                $('#username_customer').val($(this).data('username'))
                $('#name_customer').val($(this).data('name'))
                $('#gender_customer').val($(this).data('gender'))
                $('#role_customer').val($(this).data('role'))

                $('#customer_position_customer').val($(this).data('position'))
                $('#phone_customer').val($(this).data('phone'))
                $('#street_customer').val($(this).data('street'))
                $('#rt_customer').val($(this).data('rt'))
                $('#rw_customer').val($(this).data('rw'))
                $('#village_customer').val($(this).data('village'))
                $('#sub_district_customer').val($(this).data('sub_district'))
                $('#current_appointment_letter_customer').attr('onclick', `window.open('${webBaseUrl}/storage/appointment_letter/${$(this).data('appointment_letter')}')`);
            })
            $('.btn-edit-opd').on('click', function () {
                $('.dropify-clear').click()

                $('#id_opd').val($(this).data('id'))
                $('#username_opd').val($(this).data('username'))
                $('#name_opd').val($(this).data('name'))
                $('#role_opd').val($(this).data('role'))

                $('#position_opd').val($(this).data('position'))
                $('#phone_opd').val($(this).data('phone'))
                $('#street_opd').val($(this).data('street'))
                $('#rt_opd').val($(this).data('rt'))
                $('#rw_opd').val($(this).data('rw'))
                $('#village_opd').val($(this).data('village'))
                $('#sub_district_opd').val($(this).data('sub_district'))
            })
        },
        initComplete: () => {
            if (customerPosition == null) getExistingCustomerPosition()
            else {
                options = `<option disabled hidden selected>Pilih Jabatan</option>`
                customerPosition.forEach((item, _index) => {
                    options += `<option value='${item}'>` + item + "</option>"
                });
                $('#customer_position_customer').html(options)
            }

            if (gender == null) {
                getExistingGender()
                setGender('gender_customer')
            }
            else setGender('gender_customer')
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
                options += `<option value='${item}'>` + item + "</option>"
            });
            $('#role').html(options)
        },
        error: (err) => {
            console.log(err)
        }
    })
}

function getExistingCustomerPosition() {
    $.ajax({
        url: apiBaseUrl + "/user/get-existing-customer-position",
        type: "GET",
        async: false,
        success: (res) => {
            customerPosition = res

            setCustomerPositionOption()
        },
        error: (err) => {
            console.log(err)
        }
    })
}

function setCustomerPositionOption() {
    options = `<option disabled hidden selected>Pilih Jabatan</option>`
    customerPosition.forEach((item, _index) => {
        options += `<option value='${item}'>` + item + "</option>"
    });
    $('#customer_position').html(options)
}

function getExistingGender() {
    $.ajax({
        url: apiBaseUrl + "/user/get-gender-enum",
        type: "GET",
        async: false,
        success: (res) => {
            gender = res
            setGender('gender')
        },
        error: (err) => {
            console.log(err)
        },
    })
}

function setGender(element_id) {
    $("#" + element_id).append(`<option disabled hidden selected>Pilih Jenis Kelamin</option>`)
    console.log(element_id, gender)
    gender.forEach(val => {
        $("#" + element_id).append(`
            <option value="${val}">${val}</option>
        `)
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
} // to be deleted

function editCustomer(e) {
    e.preventDefault()
    let elements = e.target.elements
    let fd = new FormData()
    if ($('#password_customer').val() == $('#password_confirm_customer').val()) {
        fd.append('id', elements.id_customer.value)
        fd.append('username', elements.username_customer.value)
        fd.append('password', elements.password_customer.value)
        fd.append('name', elements.name_customer.value)
        fd.append('gender', elements.gender_customer.value)
        fd.append('customer_position', elements.customer_position_customer.value)
        console.log(elements.appointment_letter_customer.files[0])
        if (elements.appointment_letter_customer.files[0] != undefined) { fd.append('appointment_letter', elements.appointment_letter_customer.files[0]) }
        // else fd.append('appointment_letter', null)
        fd.append('phone', elements.phone_customer.value)

        fd.append('street', elements.street_customer.value)
        fd.append('rt', elements.rt_customer.value)
        fd.append('rw', elements.rw_customer.value)
        fd.append('village', elements.village_customer.value)
        fd.append('sub_district', elements.sub_district_customer.value)
        $.ajax({
            url: apiBaseUrl + '/user/admin/update-customer',
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: () => {
                $('.btn-submit').css('display', 'none')
                $('.p-loading').css('display', 'flex')
            },
            success: (res) => {
                toastr.success('Data Berhasil diperbarui')
                $('.modal-close').click()
                dt.ajax.reload()
            },
            error: (err) => {
                if (err.responseJSON.errors !== null) {
                    for (let i = 0; i < err.responseJSON.errors.length; i++) {
                        toastr.error(err.responseJSON.errors[i])
                    }
                }
                else {
                    toastr.error('Aksi gagal, harap coba lagi nanti!')
                }
            },
            complete: () => {
                $('.btn-submit').css('display', 'block')
                $('.p-loading').css('display', 'none')
            }
        })
    } else {
        toastr.error('Password baru dan konfirmasi tidak sama!')
    }
}

function editOpd(e) {
    e.preventDefault()

    if ($('#password_opd').val() == $('#password_confirm_opd').val()) {
        $.ajax({
            url: apiBaseUrl + '/user/admin/update-opd',
            type: "POST",
            data: {
                id: $('#id_opd').val(),
                name: $('#name_opd').val(),
                username: $('#username_opd').val(),
                password: $('#password_opd').val(),
                password_confirm: $('#password_confirm_opd').val(),
                street: $('#street_opd').val(),
                rt: $('#rt_opd').val(),
                rw: $('#rw_opd').val(),
                village: $('#village_opd').val(),
                sub_district: $('#sub_district_opd').val(),
                phone: $('#phone_opd').val()
            },
            beforeSend: () => {
                $('.btn-submit').css('display', 'none')
                $('.p-loading').css('display', 'flex')
            },
            success: (res) => {
                toastr.success('Data Berhasil diperbarui')
                $('.modal-close').click()
                dt.ajax.reload()
            },
            error: (err) => {
                if (err.responseJSON.errors !== null) {
                    for (let i = 0; i < err.responseJSON.errors.length; i++) {
                        toastr.error(err.responseJSON.errors[i])
                    }
                }
                else {
                    toastr.error('Aksi gagal, harap coba lagi nanti!')
                }
            },
            complete: () => {
                $('.btn-submit').css('display', 'block')
                $('.p-loading').css('display', 'none')
            }
        })
    } else {
        toastr.error('Password baru dan konfirmasi tidak sama!')
    }
}

function addCustomer(e) {
    e.preventDefault()
    let elements = e.target.elements
    let authContent = ''
    let fd = new FormData();

    fd.append('username', elements.username.value)
    fd.append('password', elements.password.value)
    fd.append('name', elements.name.value)
    fd.append('gender', elements.gender.value)
    fd.append('customer_position', elements.customer_position.value)
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
                errMsg += '<li>' + msg + '</li>'
            });
            $(document).ready(function () {
                $('.errors').html(errMsg)
                $('.errors').css('display', 'block')
            })
            toastr.error('Gagal mendaftarkan akun, atribut dengan tanda * wajib diisi, harap cek ulang form anda!')
        },
        complete: function () {
            $('.form-spinner').addClass('visually-hidden')
            $('.auth-content').html(authContent)
        }
    })
}

function changeUserStatus(e) {
    e.preventDefault()

    let footer = ''
    let elements = e.target.elements
    let fd = new FormData();

    fd.append('_token', elements._token.value)
    fd.append('_method', elements._method.value)
    fd.append('id', elements.id.value)
    fd.append('status', elements.status.value)

    $.ajax({
        url: apiBaseUrl + '/user/admin/change-user-status',
        method: "POST",
        data: fd,
        processData: false,
        contentType: false,
        beforeSend: function () {
            footer = $('#changeUserStatusForm .modal-footer').html()
            $('#changeUserStatusForm .modal-footer').html(' ')
        },
        success: function (res) {
            $('.modal-close').click()
            toastr.success('Sukses mengubah status')
            dt.ajax.reload()
        },
        error: function (err) {
            console.log(err)
        },
        complete: function () {
            $('#changeUserStatusForm .modal-footer').html(footer)
        }
    })
}