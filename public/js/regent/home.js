var dt = null
var opd = null
var opdTaskChart = null

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

function summary(data) {
    $.ajax({
        url: apiBaseUrl + "/user/regent/summary",
        type: 'GET',
        data: data,
        success: (res) => {
            let data = res.data
            let xValues = []
            let yValues = []
            var barColors = ["red", "green", "blue"]
            let card = ``

            data.forEach(element => {
                xValues.push(element.title)
                yValues.push(element.number)
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

            getOpd()
            let chartTitle = () => {
                console.log($('#opd_filter_selector').val())
                if ($('#opd_filter_selector').val() == '0' || $('#opd_filter_selector').val() == null) {
                    return 'semua OPD'
                } else {
                    const selectedValue = $('#opd_filter_selector').val();
                    const selectedText = $('#opd_filter_selector option[value="' + selectedValue + '"]').text();
                    console.log(selectedText)
                    return selectedText
                }
            }
            makeChart(xValues, yValues, barColors, chartTitle())

            $('#loading-filter').css('display', 'none')
        },
        error: (res) => {
            console.log(res)
        }
    })
}

function filterSummary(e) {
    e.preventDefault()

    let obj = {}
    obj.opd = $('#opd_filter_selector').val() != null ? $('#opd_filter_selector').val() : null

    $('#loading-filter').css('display', 'block')

    summary(obj)
}

function getOpd() {
    let todo = (opd) => {
        let options = '<option value="0" selected>Pilih OPD</option>'
        opd.forEach(element => {
            options += `<option value="${element.id}">${element.name}</option>`
        });
        return options
    };
    if (opd == null) {
        $.ajax({
            url: apiBaseUrl + '/user/regent/opds',
            type: "GET",
            success: (res) => {
                opd = res.data
                $('#opd_filter_selector').html(todo(opd))
                $('#opd_filter_selector').select2()
            }
        })
    }
}

function makeChart(xValues, yValues, barColors, title) {

    if (opdTaskChart != null) {
        opdTaskChart.destroy()
    }

    opdTaskChart = new Chart("opd-task-chart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: title
            },
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        min: 0
                    }
                }],
                xAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        min: 0
                    }
                }]
            }
        },
    });

}