<div class="page-heading">
    Filter Data
    <br>
    <form onsubmit="filterSummary(event)">
        <div class="row mb-2">
            <div class="col-sm-4 d-flex justify-between align-content-center">
                <select class="form-control" style="max-width: 200px" name="opd_filter_selector" id="opd_filter_selector">
                    
                </select>
                <button type="submit" class="btn btn-primary p-2 ml-2 mr-2">Filter</button>
            </div>
            <div class="col-sm-2">
                <p id="loading-filter" style="display: none">Loading...</p>
            </div>
        </div>
    </form>
    <div class="row card-container">

    </div>
</div>

<script>
    $("#title-label").html('Ringkasan Data')
</script>