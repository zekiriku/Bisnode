function setBtnEvent() {
    $('.btn').on('click', function (event) {
        event.preventDefault();
        $('.modal').modal('show');
        $.ajax({
            url : $(this).attr('href'),
            type : 'GET',
            success : function(response, status){
                title = $(response).filter('h1').html();
                updateModal(title, response, $(this));

            }.bind(this),

            error : function(response, status, error){
                updateModal('Error', error, $(this));
            }.bind(this)

        });
    })
}

function updateModal(title, content, btn) {
    $('.modal .modal-body').html(content);
    $('.modal .modal-title').html(title);
    if(btn.data('action-btn')){
        $('.modal .save-btn').show();
        $('.modal .save-btn').removeClass('btn-primary');
        $('.modal .save-btn').removeClass('btn-danger');
        $('.modal .save-btn').html(btn.data('action-btn-title'));
        $('.modal .save-btn').addClass(btn.data('action-btn-class'));
        sendForm();
    }else{
        $('.modal .save-btn').hide();
    }
}

function sendForm() {
    var sendbtn = $('.modal .save-btn');
    sendbtn.unbind('click');
    sendbtn.on('click', function (event) {
        event.preventDefault();
        var form = $('.modal form');
        var data = form.serializeArray();
        var re = new RegExp(userUrls.delete);
        if(re.test(form.attr('action'))){
            data.push({name: "del", value: 'Yes'});
        }
        $.ajax({
            url : form.attr('action'),
            type : 'POST',
            data: $.param(data),
            success : function(response, status){
                $('.dataTable').DataTable().ajax.reload();
                $('.modal').modal('hide');
                $('.flashmessage-ajax').html(
                    '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '<ul><li>' + response.message + '</li></ul></div>'
                );
            }.bind(this),

            error : function(response, status, error){
                $('.modal .modal-body').html(response.responseText);
            }.bind(this)

        });
    })
}
