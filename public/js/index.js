const webBaseUrl = window.location.origin
const apiBaseUrl = webBaseUrl + '/api/v1'

function authCheck() {  
    // console.log(localStorage.getItem('_token'))
    if (localStorage.getItem('_token') != null) {
        $.ajax({
            url: webBaseUrl + '/authenticator',
            type: "GET",
            headers: {
                Authorization: 'bearer ' + localStorage.getItem('_token')
            },
            success: (res) => {
                // console.log(res)
                $('#app').html(res)
                let indexjs = document.createElement('script');
                indexjs.setAttribute('type', 'text/javascript');
                indexjs.setAttribute('src', webBaseUrl+'/js/main.js');
                document.head.appendChild(indexjs);
                getFacilities()
            },
            error: (err, text, statusMessage) => {
                // console.log(text, err, statusMessage)
                if(err.responseJSON.status == 400 && err.responseJSON.token != null) {
                    // console.log("reload")
                    localStorage.setItem('_token', err.responseJSON.token)
                    window.location.reload()
                }else if (err.responseJSON.status != 400) {
                    // console.log("pindah")
                    window.location.href = webBaseUrl+'/login'
                }
            }
        })
    }else {
        window.location.href = webBaseUrl+'/login'
    }
}
authCheck()

function getFacilities() {
    $.ajax({
        url: apiBaseUrl+'/user/get-facilities',
        type: "GET",
        headers: {
            Authorization: 'bearer ' + localStorage.getItem('_token')
        },
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
            if (err.responseJSON.status == 400) {
                localStorage.setItem('_token', err.responseJSON._token)
                getFacilities()
            }else {
                window.location.reload()
            }
        }
    })
}

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

            $('#makeReport').on('submit', function (e) {  
                e.preventDefault()
                let fd = new FormData()
                fd.append('proof', $('#proof')[0].files[0])
                fd.append('issue', $('#issue').val())
                fd.append('facility', $('#facility').val())
                fd.append('location', $('#location').val())
                fd.append('_token', "{{ csrf_token() }}")
                $.ajax({
                    url: apiBaseUrl + '/user/report',
                    type: 'POST',
                    headers: {
                        Authorization: 'bearer' + localStorage.getItem('_token')
                    },
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: (res) => {
                        console.log(res)
                    },
                    error: (err) => {
                        console.log(err)
                    }
                })
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

// function reportHistoryPage() {
//     $.ajax({
//         url: webBaseUrl + '/customer/report-history-page',
//         type: "GET",
//         headers: {
//             Authorization: "bearer "+localStorage.getItem('_token')
//         },
//         beforeSend: () => {
//             $('#content').html(`
//             <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
//                 <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
//                     <span class="visually-hidden">Loading...</span>
//                 </span>
//             </span>
//             `)
//             $('.nav-item').removeClass('active')
//             $('.dropdown-item').removeClass('active')
//             $('#home').addClass('active')
//         },
//         success: (res) => {
//             $('#content').html(res)
//         },
//         error: (err) => {
//             if (err.responseJSON.status == 400) {
//                 localStorage.setItem('_token', err.responseJSON._token)
//                 homePage()
//             }else {
//                 window.location.reload()
//             }
//         }
//     })
// }

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