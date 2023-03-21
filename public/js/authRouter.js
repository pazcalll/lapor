const webBaseUrl = window.location.origin
const apiBaseUrl = webBaseUrl + '/api/v1'

function loginPage() {
    document.title = 'Lapor | Login'
    $.ajax({
        url: webBaseUrl + '/login-page',
        type: 'GET',
        beforeSend: function () {
            $('.form-spinner').removeClass('visually-hidden')
            $('.auth-content').html(' ')
        },
        success: function (res) {
            $('.auth-content').html(res)
        },
        error: function (err) {
            console.log(err)
        },
        complete: function () {
            $('.form-spinner').addClass('visually-hidden')
        }
    })
}

function registerPage() {
    document.title = 'Lapor | Register'
    $.ajax({
        url: webBaseUrl + '/register-page',
        type: 'GET',
        beforeSend: function () {
            $('.form-spinner').removeClass('visually-hidden')
            $('.auth-content').html(' ')
        },
        success: function (res) {
            $('.auth-content').html(res)
        },
        error: function (err) {
            console.log(err)
        },
        complete: function () {
            $('.form-spinner').addClass('visually-hidden')
        }
    })
}

function login(e) {
    e.preventDefault()
    let elements = e.target.elements
    let returner = (content) => {
        return content
    }
    let authContent = ''
    $.ajax({
        url: apiBaseUrl + '/login',
        type: "POST",
        data: {
            username: elements.username.value,
            password: elements.password.value
        },
        beforeSend: function () {
            $('.form-spinner').removeClass('visually-hidden')
            authContent = returner($('.auth-content').html())
            $('.auth-content').html(' ')
        },
        success: (res) => {
            localStorage.setItem('_token', res._token)
            window.location.href = webBaseUrl + '/dashboard'
        },
        error: function (err) {
            console.log(err)
            let errMsg = ''
            Object.entries(err.responseJSON.error).forEach((entry) => {
                const [key, error] = entry;
                error.forEach(element => {
                    errMsg += element + `<br>`
                });
            });
            toastr.error('Login gagal')
            $('.auth-content').html(authContent)
            $('#errors').addClass("alert alert-danger")
            $('#errors').removeClass('visually-hidden')
            $('#errors').html(errMsg)
            console.log($('#errors').html())
            // $(document).ready(function () {  
            // })
        },
        complete: function () {
            $('.form-spinner').addClass('visually-hidden')
            // $('.auth-content').html(authContent)
        }
    })
}

function register(e) {
    e.preventDefault()
    let elements = e.target.elements
    let returner = (content) => {
        return content
    }
    let authContent = ''
    $.ajax({
        url: apiBaseUrl + '/register',
        type: "POST",
        data: {
            username: elements.username.value,
            password: elements.password.value,
            name: elements.name.value,
            phone: elements.phone.value,
            address: elements.address.value
        },
        beforeSend: function () {
            $('.form-spinner').removeClass('visually-hidden')
            authContent = returner($('.auth-content').html())
            $('.auth-content').html(' ')
        },
        success: (res) => {
            toastr.success('Sukses mendaftarkan akun')
        },
        error: function (err) {
            let errMsg = ''
            Object.entries(err.responseJSON.error).forEach((entry) => {
                const [key, error] = entry;
                error.forEach(element => {
                    errMsg += element + `<br>`
                });
            });
            $(document).ready(function () {
                $('.errors').html(errMsg)
                $('.errors').removeClass('visually-hidden')
            })
            toastr.error('Gagal mendaftarkan akun')
        },
        complete: function () {
            $('.form-spinner').addClass('visually-hidden')
            $('.auth-content').html(authContent)
        }
    })
}