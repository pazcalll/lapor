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
                $('#app').html(res)        
                let script = document.createElement('script');
                script.setAttribute('type', 'text/javascript');
                script.setAttribute('src', webBaseUrl+'/js/main.js');
                document.head.appendChild(script);
                getFacilities()
            },
            error: (err, text, errThrow) => {
                console.log(text, err, errThrow)
                // if(err.status == 400 && err.token != null) {
                //     localStorage.setItem('_token', err.token)
                //     $('#app').html(res)
                //     let script = document.createElement('script');
                //     script.setAttribute('type', 'text/javascript');
                //     script.setAttribute('src', webBaseUrl+'/js/main.js');
                //     document.head.appendChild(script);
                //     getFacilities()
                // }else if (err.status != 400) {
                //     window.location.href = webBaseUrl+'/login'
                // }
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