$( document ).ready(function() {
    $('.dataTable').DataTable({
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            null,
            { "orderable": false }
        ]
    });
});
