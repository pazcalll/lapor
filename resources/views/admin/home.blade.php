<div class="page-heading">
    Filter Data
    <br>
    <form onsubmit="filterSummary(event)">
        <div class="row mb-2">
            <div class="col-sm-4 d-flex justify-between align-content-center">
                <select class="form-control" style="max-width: 200px" name="opd_filter_selector" id="opd_filter_selector"></select>
                <button type="submit" class="btn btn-primary p-2 ml-2 mr-2">Filter</button>
            </div>
            <div class="col-sm-2">
                <p id="loading-filter" style="display: none">Loading...</p>
            </div>
        </div>
    </form>
    <div class="row card-container">

    </div>
    <div class="graphic">
        <div class="d-flex justify-content-center align-items-center">
            <canvas id="opd-task-chart" style="width:100%;max-width:600px"></canvas>
        </div>
    </div>
</div>

<div class="page-heading">
    Filter Fasilitas
    <br>
    <form onsubmit="filterFacility(event)">
        <div class="row mb-2">
            <div class="col-sm-4 d-flex justify-between align-content-center">
                <select class="form-control" style="max-width: 200px" name="facility_filter_selector" id="facility_filter_selector"></select>
            </div>
            <div class="col-sm-2">
                <p id="loading-filter" style="display: none">Loading...</p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 d-flex justify-between align-content-center">
                <select class="form-control" style="max-width: 80px" name="start_year_filter_selector" id="start_year_filter_selector"></select>
                <select class="form-control" style="max-width: 80px" name="end_year_filter_selector" id="end_year_filter_selector"></select>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 d-flex justify-between align-content-center">
                <button type="submit" class="w-100 btn btn-primary p-2 ml-2 mr-2">Filter</button>
            </div>
        </div>
    </form>
    <div class="graphic">
        <div class="d-flex justify-content-center align-items-center">
            <canvas id="facility-task-chart" style="width:100%;max-width:1024px"></canvas>
        </div>
    </div>
</div>

<script>
    $("#title-label").html('Dashboard')
</script>