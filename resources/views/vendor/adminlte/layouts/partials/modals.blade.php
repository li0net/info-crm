<!-- Modal -->

<div class="modal fade" id="biModal" tabindex="-1" role="dialog" aria-labelledby="biModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="biModalLabel">Modal title</h4>
            </div>
            <div class="modal-header modal-header-empty">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Show modal window
     * @param text  - REQUIRED, window body. can be text or object
     * @param title - window title
     * @param type  - modal/error/message/info
     * @param data  - other data for modal.
     *              - Now implemented [hideButtons], [buttonId] and [buttonClass].
     *              - Be free to add owns the same way
     */
    function showBiModal(text, title, type, data) {
        //checking params
        if (text === undefined ) {
            return false;
        }
        if (title === undefined ) {
            title = '';
        }
        if (type === undefined) {
            type = 'modal';
        }
        if (data === undefined) {
            data = {};
        }

        //div-template to use
        var modalTpl = $('#biModal');

        // hiding title area if don't need
        if (title == '' || type == 'error' || type == 'message' || type == 'info'){
            modalTpl.find('.modal-header').hide();
            modalTpl.find('.modal-header-empty').show();
        } else {
            modalTpl.find('.modal-header').show();
            modalTpl.find('.modal-header-empty').hide();
            modalTpl.find('.modal-title').html(title);
        }

        // put window's text
        switch (type) {
            case 'error':
            case 'message':
            case 'info':
            case 'modal':
                modalTpl.find('.modal-body').html(text);
                break;
            default:
                modalTpl.find('.modal-body').html(text);
        }

        //set button's id if need
        if (data['hideButtons'] !== 'undefined' && data['hideButtons'] == true){
            modalTpl.find('.modal-footer').hide();
        } else {

            modalTpl.find('.modal-footer').show();

            if (data['buttonId'] !== 'undefined'){
                modalTpl.find('.btn-primary').attr('id',data['buttonId']);
            }
            //set primary button's class if need
            if (data['buttonClass'] !== 'undefined'){
                modalTpl.find('.btn-primary').addClass(data['buttonClass']);
            }
        }

        // init modal
        modalTpl.modal();

        // clear on hide
        modalTpl.on('hide.bs.modal', function (event) {
            var modal = $(this);
            modal.find('.modal-title').html('');
            modal.find('.modal-body').html('');
        });
    }

    /**
     * отображение сообщения об ошибке в модальном окне
     * @param text
     */
    function showBiModalError(text)
    {
        $('#biModal .modal-body').prepend("<div class='alert alert-error visible'><i class='fa fa-info-circle'' aria-hidden='true'></i>"+ text + "</div>");
    }

    /**
     * отображение успешного сообщения в модальном окне
     * @param text
     */
    function showBiModalMessage(text)
    {
        $('#biModal .modal-body').prepend("<div class='alert alert-success visible'><i class='fa fa-info-circle'' aria-hidden='true'></i>"+ text + "</div>");
    }

</script>