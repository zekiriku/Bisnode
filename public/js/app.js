$( document ).ready(function() {
    var table = $('.dataTable').DataTable({
        "ajax": {
            "url": userUrls.users,
            "dataSrc": "data",
            "dataType": "json",
            "contentType": "application/json; charset=utf-8"
        },
        "pageLength": 50,

        "columns": [
            { data: "id" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
            { data: "position" },
            {
                data: null,
                orderable: false,
                defaultContent: '<a class="btn btn-default btn-show" data-action-btn="false" data-action-btn-type="none" href="">Show</a> ' +
                    '<a class="btn btn-primary btn-edit" data-action-btn="true" data-action-btn-class="btn-primary" data-action-btn-title="Update" href="">Edit</a> ' +
                    '<a class="btn btn-danger btn-delete" data-action-btn="true" data-action-btn-class="btn-danger" data-action-btn-title="Yes"">Delete</a>'
            }
        ]
    });
    table.on( 'draw', function () {
        $('.table > tbody  > tr').each(function() {
            var userId = $(this).find('td:first').text()
            $(this).find('.btn-show').attr('href', userUrls.show + userId);
            $(this).find('.btn-edit').attr('href', userUrls.edit + userId);
            $(this).find('.btn-delete').attr('href', userUrls.delete + userId);
        });
        if (typeof setBtnEvent === "function"){
            setBtnEvent();
        }
    });
});
