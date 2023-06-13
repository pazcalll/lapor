var dt = null
var opds = []
var opdTaskChart = null
var facilities = []
var facilitiesTaskChart = null
var months = [
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
]
var monthBarColors = [
    '#eb3434',
    '#eb9834',
    '#ebeb34',
    '#b7eb34',
    '#7deb34',
    '#43eb34',
    '#34eb99',
    '#34ebeb',
    '#3480eb',
    '#343aeb',
    '#7d34eb',
    '#c034eb'
]

function homePage() {
    $.ajax({
        url: webBaseUrl + '/admin/home-page',
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
            getOpds()
                .then(summary())
                .then(getFacilities())
        },
        error: (err) => {
            // console.log(err)
            window.location.reload()
        }
    })
}
homePage()

function summary(data) {
    $.ajax({
        url: apiBaseUrl + "/user/admin/summary",
        type: 'GET',
        data: data,
        success: (res) => {
            let data = res.data
            let xValues = []
            let yValues = []
            var barColors = ["#c2c2c2", "#ffae00", "#70c24a"]
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

            if ($('#opd_filter_selector').html() == '') {
                let todo = (opds) => {
                    let options = '<option value="0" selected>Pilih OPD</option>'
                    opds.forEach(element => {
                        options += `<option value="${element.id}">${element.name}</option>`
                    });
                    return options
                };
                $('#opd_filter_selector').html(todo(opds))
                $('#opd_filter_selector').select2()
            }

            let chartTitle = () => {
                console.log($('#opd_filter_selector').val())
                if ($('#opd_filter_selector').val() == '0' || $('#opd_filter_selector').val() == null) {
                    return 'semua OPD'
                } else {
                    const selectedValue = $('#opd_filter_selector').val();
                    const selectedText = $('#opd_filter_selector option[value="' + selectedValue + '"]').text();
                    return selectedText
                }
            }
            makeChartOpd(xValues, yValues, barColors, chartTitle())

            $('#loading-filter').css('display', 'none')
        },
        error: (res) => {
            console.log(res)
        }
    })
}

function getOpds() {
    return $.ajax({
        url: apiBaseUrl + "/user/admin/opds",
        type: "GET",
        success: (res) => {
            options = `<option value='default' disabled hidden selected>Pilih OPD</option>`
            opds = []
            res.data.forEach((opd, _index) => {
                opds.push({
                    id: opd.id,
                    name: opd.name
                })
                options += `<option value='${opd.id}'>` + opd.name + "</option>"
            });
            $('#opd').html(options)
        },
        error: (err) => {
            console.log(err)
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

function makeChartOpd(xValues, yValues, barColors, title) {
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
                text: title,
                fontSize: 20
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

function getFacilities() {
    return $.ajax({
        url: apiBaseUrl + '/user/get-facilities',
        type: "GET",
        success: (res) => {
            facilities = res
            setFacilities()
            let xValues = months
            let yValues = []
            for (let i = 1; i <= 12; i++) {
                yValues.push(0);
            }
            let barColors = monthBarColors
            let title = 'Laporan Bulanan Per Tahun'
            makeChartFacilities(xValues, yValues, barColors, title)
        },
        error: (err) => {
            console.log(err)
        },
        complete: () => {
            setYearFilters()
        }
    })
}

function setFacilities() {
    facilitySelector = null
    facilitySelector += `<option selected disabled>Pilih Fasilitas</option>`

    facilities.forEach(facility => {
        facilitySelector += `<option value="${facility.id}">${facility.name}</option>`
    });
    $('#facility_filter_selector').html(facilitySelector)
    $('#facility_filter_selector').select2()
}

function setYearFilters() {
    let years = ''
    for (let i = 2000; i <= new Date().getFullYear(); i++) {
        years += `<option value="${i}">${i}</option>`
    }

    $('#year_filter_selector').html(`<option selected disabled>Pilih Tahun</option>${years}`)

    $('#year_filter_selector').select2()
}

function filterFacility(e) {
    e.preventDefault()

    let obj = {}
    obj.facility_id = $('#facility_filter_selector').val() != null ? $('#facility_filter_selector').val() : null
    obj.year = $('#year_filter_selector').val() != null ? $('#year_filter_selector').val() : null

    $('#loading-filter-yearly').css('display', 'block')

    if (obj.facility_id != null && obj.year != null) {
        $.ajax({
            url: apiBaseUrl+'/user/admin/yearly-report',
            type: "GET",
            data: obj,
            success: (res) => {
                console.log(res)
                let yValues = []
                for (let index = 0; index < 12; index++) {
                    yValues.push(0)
                }
                res.forEach(monthlyData => {
                    yValues[monthlyData.month - 1] = monthlyData.count
                });
                makeChartFacilities(months, yValues, monthBarColors, 'Laporan Bulanan Per Tahun')
            },
            error: (err) => {
                console.log(err)
            },
            complete: () => {
                $('#loading-filter-yearly').css('display', 'none')
            }
        })
    } else {
        $('#loading-filter-yearly').css('display', 'none')
        let yValues = []
        for (let index = 0; index < 12; index++) {
            yValues.push(0)
        }
        makeChartFacilities(months, yValues, monthBarColors, 'Laporan Bulanan Per Tahun')
    }
}

function makeChartFacilities(xValues, yValues, barColors, title) {

    if (facilitiesTaskChart != null) {
        facilitiesTaskChart.destroy()
    }

    facilitiesTaskChart = new Chart("facility-task-chart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            responsive: true,
            legend: { display: false },
            title: {
                display: true,
                text: title,
                fontSize: 20
            },
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        suggestedMax: 10
                    }
                }],
                xAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        fontSize: 14
                    }
                }],
            }
        },
    });

}

// function confirmationOPD(referral, ele) {
//     $('.referral_confirmOPD').html(referral)
//     $('#confirmOPDModal').modal('show')

//     $('#confirmOPDModal #referral').val(referral)
//     for (let i = 0; i < opds.length; i++) {
//         if (opds[i].id == ele.value) {
//             $('.opd_spill').html(opds[i].name)
//         }
//     }
//     $('#confirmOPDModal #opd').val(ele.value)
//     // console.log($('#confirmOPDModal #opd'))
//     // console.log($('#confirmOPDModal #referral').val())
// }
