var dt = null

// ====================================== HOME PAGE =================================================
function homePage() {
    $.ajax({
        url: webBaseUrl + '/customer/home-page',
        type: "GET",
        headers: {
            Authorization: "bearer "+localStorage.getItem('_token')
        },
        beforeSend: () => {
            $('#content').html(`
            <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
            </span>
            `)
            $('.nav-item').removeClass('active')
            $('.dropdown-item').removeClass('active')
            $('#home').addClass('active')
        },
        success: (res) => {
            $('#content').html(res)
            
            $('#makeReport').on('submit', function (e) {  
                e.preventDefault()
                let fd = new FormData()
                let fileSelector = document.getElementsByClassName('dropify')
                let files = []
                for (let i = 0; i < fileSelector.length; i++) {
                    // files.push(fileSelector[i])
                    fd.append('proof[]', $('.dropify')[i].files[0])
                }
                fd.append('issue', $('#issue').val())
                fd.append('facility', $('#facility').val())
                fd.append('street', $('#street').val())
                fd.append('village', $('#village').val())
                fd.append('sub_district', $('#sub_district').val())
                fd.append('rw', $('#rw').val())
                fd.append('rt', $('#rt').val())
                // fd.append('_token', "{{ csrf_token() }}")
                
                $('.btn-close').click()
                $('#issue').val(null)
                $('#facility').val(0)
                $('#rt').val(null)
                $('#rw').val(null)
                $('#sub_district').val(null)
                $('#village').val(null)
                $('#street').val(null)
                $('.proof-container').html(`
                    <div class="row">
                        <div class="col-sm-2">
                            <input type="file" name="proof" id="proof" class="dropify" required type="file" data-plugin="dropify" data-max-file-size="1M" >
                        </div>
                        <div class="col-sm-2 justify-content-center align-self-center uploader-adder">
                            <button type="button" onclick="addFileUploader()" class="btn btn-success" title="Tambah Masukan Bukti" style="border-radius: 10px; height: max-content; transform: translateY(-50%); position: absolute; top: 50%; bottom: 50%;">
                                <i class="zmdi zmdi-plus zmdi-hc-4x"></i>
                            </button>
                        </div>
                    </div>
                `)
                $('.dropify').dropify({
                    messages: {
                        'default': 'Masukkan bukti',
                        'replace': 'Masukkan ganti dengan bukti lain',
                        'remove':  'Hapus',
                        'error':   'Maaf, terjadi kesalahan.'
                    },
                    error: {
                        'fileSize': 'Ukuran terlalu besar (1 mb max).',
                    },
                    tpl: {
                        clearButton: '<button type="button" onclick="removeFileInput(this)" class="dropify-clear">Hapus</button>'
                    }
                })

                $.ajax({
                    url: apiBaseUrl+'/user/customer/report',
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: (res) => {
                        toastr.success('Sukses membuat laporan!')
                        reportPage()
                    },
                    error: (err) => {
                        toastr.error('Laporan gagal dikirim, coba lagi nanti!')
                        console.log(err)
                    }
                })
            })
            getFacilities()
        },
        error: (err) => {
            if (err.responseJSON.status == 400) {
                localStorage.setItem('_token', err.responseJSON._token)
                homePage()
            }else {
                window.location.reload()
            }
        }
    })
}
homePage()

function removeFileInput(element) {
    let e = element 
    let uploaderCounter = document.getElementsByClassName('dropify')
    
    if (uploaderCounter.length == 1) {
        return
    }
    
    e.parentElement.parentElement.remove()
}

function addFileUploader(adder) {
    let uploaderCounter = document.getElementsByClassName('dropify')
    for (var i = 0; i < uploaderCounter.length; i++) {
        if (uploaderCounter[i].value == "" || uploaderCounter[i].value == null) {
            toastr.error("Form upload bukti yang ada wajib diisi sebelum membuat yang baru!")
            return
        }
        else if (uploaderCounter.length >= 5){
            toastr.error("Form upload bukti tidak bisa lebih dari 5!")
            return
        }
    }
    $('.uploader-adder').remove()
    let timestamp = Date.now()
    $('.proof-container .row').append(`
        <div class="col-sm-2">
            <input type="file" id="proof${timestamp}" class="dropify" required type="file" data-plugin="dropify" data-max-file-size="1M" >
        </div>
    `)
    $('#proof'+timestamp).dropify({
        messages: {
            'default': 'Masukkan bukti',
            'replace': 'Masukkan ganti dengan bukti lain',
            'remove':  'Hapus',
            'error':   'Maaf, terjadi kesalahan.'
        },
        error: {
            'fileSize': 'Ukuran terlalu besar (1 mb max).',
        },
        tpl: {
            clearButton: '<button type="button" onclick="removeFileInput(this)" class="dropify-clear">Hapus</button>'
        }
    })
    $('.proof-container .row').append(`
        <div class="col-sm-2 justify-content-center align-self-center uploader-adder">
            <button type="button" onclick="addFileUploader(this)" class="btn btn-success" title="Tambah Masukan Bukti" style="border-radius: 10px; height: max-content; transform: translateY(-50%); position: absolute; top: 50%; bottom: 50%;">
                <i class="zmdi zmdi-plus zmdi-hc-4x"></i>
            </button>
        </div>
    `)
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

function getFacilities() {
    $.ajax({
        url: apiBaseUrl+'/user/get-facilities',
        type: "GET",
        success: (res) => {
            let facilityHTML = '<option selected disabled hidden>Pilih Fasilitas</option>'
            res.forEach(facility => {
                facilityHTML += `
                    <option value="${facility.id}">${facility.name}</option>
                `
            });
            $('#facility').html(facilityHTML)
        },
        error: (err) => {
            if (err.responseJSON.status == 400) {
                localStorage.setItem('_token', err.responseJSON._token)
                getFacilities()
            }else {
                window.location.reload()
            }
        }
    })
}

// ==================================================== REPORT PAGE ===============================================
function reportPage() {  
    $.ajax({
        url: webBaseUrl + '/customer/report-page',
        type: "GET",
        headers: {
            Authorization: "bearer "+localStorage.getItem('_token')
        },
        beforeSend: () => {
            $('#content').html(`
            <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
            </span>
            `)
            $('.nav-item').removeClass('active')
            $('.dropdown-item').removeClass('active')
            $('#report').addClass('active')
        },
        success: (res) => {
            $('#content').html(res)
            
            getFacilities()
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
            dt = $('#report_queue').DataTable({
                ajax: {
                    url: apiBaseUrl + '/user/customer/unaccepted-reports',
                    headers: {
                        Authorization: "bearer " + localStorage.getItem('_token')
                    },
                    cache: true
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
                ],
                columns: [
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
                                <button data-backdrop="false" data-toggle="modal" data-target="#proofModal" type="button" class="btn btn-success btn-proof" data-referral="${data.referral}" ${dataFiles}>Bukti</button>
                            `
                        }
                    },
                    {
                        data: 'status'
                    }
                ],
                drawCallback: () => {
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
        },
        error: (err) => {
            if (err.responseJSON.status == 400) {
                localStorage.setItem('_token', err.responseJSON._token)
                reportPage()
            }else {
                window.location.reload()
            }
        }
    })
}

// ================================================================ HISTORY PAGE =================================================

function reportHistoryPage() {
    $.ajax({
        url: webBaseUrl + '/customer/report-history-page',
        type: "GET",
        headers: {
            Authorization: "bearer "+localStorage.getItem('_token')
        },
        beforeSend: () => {
            $('#content').html(`
            <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
            </span>
            `)
            $('.nav-item').removeClass('active')
            $('.dropdown-item').removeClass('active')
            $('#history').addClass('active')
        },
        success: (res) => {
            $('#content').html(res)
            
            dt = $('.table').DataTable({
                ajax: {
                    url: apiBaseUrl + '/user/customer/reports',
                    headers: {
                        Authorization: "bearer " + localStorage.getItem('_token')
                    },
                    cache: true
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
                    { width: '15%', targets: 3 },
                    { width: '25%', targets: 4 },
                    { width: '10%', targets: 5 },
                    { width: '10%', targets: 6 },
                ],
                columns: [
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
                        data: 'assignment.opd.name',
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
                                <button data-backdrop="false" data-toggle="modal" data-target="#proofModal" type="button" class="btn btn-success btn-proof" data-referral="${data.referral}" ${dataFiles}>Bukti</button>
                            `
                        }
                    },
                    {
                        data: 'status'
                    }
                ],
                drawCallback: () => {
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
    })
}

// ============================================ PROFILE PAGE ==========================================
function profilePage() {
    $.ajax({
        url: webBaseUrl + "/profile-page",
        type: "GET",
        beforeSend:() => {
            $('#content').html(`
            <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
            </span>
            `)
        },
        success: (res1) => {
            $('.menu-backdrop').click()

            $.ajax({
                url: apiBaseUrl + "/user/get-profile",
                type: "GET",
                success: (res2) => {
                    $("#content").html(res1)

                    $('#name').val(res2.name)
                    $('#username').val(res2.username)
                    $('#password').val(res2.password)
                    $('#phone').val(res2.phone)
                    $('#street').val(res2.user_address_detail.street)
                    $('#rt').val(res2.user_address_detail.rt)
                    $('#rw').val(res2.user_address_detail.rw)
                    $('#village').val(res2.user_address_detail.village)
                    $('#sub_district').val(res2.user_address_detail.sub_district)
                    $('#appointment_letter_link').data('url', webBaseUrl+"/storage/appointment_letter/"+res2.appointment_letter)

                    $('#appointment_letter_link').on('click', function () {  
                        window.open($(this).data('url'), '_blank')
                    })
                }
            })
        }
    })
}

function updateProfile(e) {
    e.preventDefault()

    if ($('#password').val() == $('#password_confirm').val()) {
        $.ajax({
            url: apiBaseUrl + '/user/update-profile',
            type: "PATCH",
            data: {
                name: $('#name').val(),
                username: $('#username').val(),
                password: $('#password').val(),
                street: $('#street').val(),
                rt: $('#rt').val(),
                rw: $('#rw').val(),
                village: $('#village').val(),
                sub_district: $('#sub_district').val(),
                phone: $('#phone').val()
            },
            beforeSend: () => {
                $('.btn-submit').css('display', 'none')
                $('.p-loading').css('display', 'flex')
            },
            success: (res) => {
                toastr.success('Data Berhasil diperbarui')
                $("#userAccount").html($('#name').val())
            },
            error: (err) => {
                if (err.responseJSON.errors !== null) {
                    for (let i = 0; i < err.responseJSON.errors.length; i++) {
                        toastr.error(err.responseJSON.errors[i])
                    }
                }
                else{
                    toastr.error('Aksi gagal, harap coba lagi nanti atau hubungi admin!')
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