$(document).ready(function() {
    $('.btn').on('click', function (event) {
        event.preventDefault();
        $('.modal').modal('show');
        $.ajax({
            url : $(this).attr('href'),
            type : 'GET',
            dataType : 'html',
            success : function(response, status){
                title = $(response).filter('h1').html();
                updateModal(title, response, $(this));

            }.bind(this),

            error : function(response, status, error){
                updateModal('Error', error, $(this));
            }.bind(this)

        });
    })
});

function updateModal(title, content, btn) {
    $('.modal .modal-body').html(content);
    $('.modal .modal-title').html(title);
    if(btn.data('action-btn')){
        $('.modal .save-btn').show();
        $('.modal .save-btn').removeClass('btn-primary');
        $('.modal .save-btn').removeClass('btn-danger');
        $('.modal .save-btn').html(btn.data('action-btn-title'));
        $('.modal .save-btn').addClass(btn.data('action-btn-class'));
    }else{
        $('.modal .save-btn').hide();
    }
}