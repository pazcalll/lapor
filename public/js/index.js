const webBaseUrl = window.location.origin
const apiBaseUrl = webBaseUrl + '/api/v1'

function authCheck() {  
    console.log(localStorage.getItem('_token'))
    if (localStorage.getItem('_token') != null) {
        $.ajax({
            url: webBaseUrl + '/indexPage',
            type: "GET",
            headers: {
                Authorization: 'bearer' + localStorage.getItem('_token')
            },
            success: (res) => {
                console.log(res)
                $('#app').html(res)        
                let indexjs = document.createElement('script');
                indexjs.setAttribute('type', 'text/javascript');
                indexjs.setAttribute('src', webBaseUrl+'/js/main.js');
                document.head.appendChild(indexjs);
                getFacilities()
            },
            error: (err, text, statusMessage) => {
                console.log(text, err, statusMessage)
                if(err.responseJSON.status == 400 && err.responseJSON.token != null) {
                    localStorage.setItem('_token', err.token)
                    window.location.reload()
                }else if (err.responseJSON.status != 400) {
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
            console.log(err)
        }
    })
}