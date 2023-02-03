
<script>
    $("#title-label").html('Ringkasan Data')

    incomingReportDatatable('{{ asset("storage/proof") }}')
    getOpds()
</script>