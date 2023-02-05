var dt = null

function homePage() {
    $.ajax({
        url: webBaseUrl + '/regent/home-page',
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
            summary()
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

function summary() {
    $.ajax({
        url: apiBaseUrl + "/user/regent/summary",
        type: 'GET',
        success: (res) => {
            let data = res.data

            let card = ``
            data.forEach(element => {
                card += `
                    <div class="col-xl-4 col-sm-6 col-12">
                        <div class="shadow border-0 card">
                            <div class="card-header border-0">${element.title}</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <h6 class="card-subtitle mb-4">${element.shortDesc}</h6>
                                        <p class="card-text">${element.number}</p>
                                        <p class="card-text ">
                                            <small>Terhitung dari semua waktu.</small>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <div disable class="mt-2" style="text-align: center; margin: 0 auto; color: ${element.iconColor}" href="javascript:void(0)">
                                            <i class="zmdi ${element.meterialIcon} zmdi-hc-5x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            });
            $('.card-container').html(card)
        },
        error: (res) => {
            console.log(res)
        }
    })
}