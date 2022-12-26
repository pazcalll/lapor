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