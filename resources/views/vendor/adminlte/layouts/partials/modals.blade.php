<!-- Modal -->
<div class="modal fade" id="biModal" tabindex="-1" role="dialog" aria-labelledby="biModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="biModalLabel">Modal title</h4>
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
     * @param title - window title
     * @param text  - window body. can be text or object
     * @param data  - other data for modal.
     *              - Now implemented buttonId and buttonId. Be free to add owns the same way
     */
    function showBiModal(title, text, data)
    {
        $('#biModal').find('.modal-title').html(title);
        $('#biModal').find('.modal-body').html(text);

        //set primary button's id if need
        if (data['buttonId'] !== 'undefined'){
            $('#biModal').find('.btn-primary').attr('id',data['buttonId']);
        }
        //set primary button's class if need
        if (data['buttonClass'] !== 'undefined'){
            $('#biModal').find('.btn-primary').addClass(data['buttonClass']);
        }

        // show modal
        $('#biModal').modal();

        // clear on hide
        $('#biModal').on('hide.bs.modal', function (event) {
            var modal = $(this);
            modal.find('.modal-title').html('');
            modal.find('.modal-body').html('');
        });
    }

    /**
     * отображение сообщения об ошибке
     * @param text
     */
    function showBiModalError(text)
    {
        $('#biModal .modal-body').prepend("<div class='alert alert-error visible'><i class='fa fa-info-circle'' aria-hidden='true'></i>"+ text + "</div>");
    }

    /**
     * отображение успешного сообщения
     * @param text
     */
    function showBiModalMessage(text)
    {
        $('#biModal .modal-body').prepend("<div class='alert alert-success visible'><i class='fa fa-info-circle'' aria-hidden='true'></i>"+ text + "</div>");
    }

</script>