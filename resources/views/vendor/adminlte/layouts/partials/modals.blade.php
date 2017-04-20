<!-- Modal -->
<div class="modal right fade" id="sideModal" tabindex="-1" role="dialog" aria-labelledby="sideModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></span></button>
            </div>
            <div class="modal-body"></div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- Modal window-->
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
            <div class="modal-footer modal-footer-welcome">
                <input type="hidden" id="organization_id" name="organization_id" value="{{ $user->organization_id }}">
                <div class="checkbox text-left">
                    <label>
                        <input type="checkbox" class="welcome-check" name="welcome-check" checked>Show this window on start.
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal windows templates -->
<div class="hidden" id="text-templates">
    <!-- welcome window template-->
    <div id="welcomeModal">
        <p>This window will help you to setup your account fast and start you work ASAP. Before you start? make suer you do following steps:</p>
        <p><i class="fa fa-check" aria-hidden="true"></i> <b>Step1.</b> Fill out organization form. Make sure...</p>
        <p><i class="fa fa-check" aria-hidden="true"></i> <b>Step2.</b> Set up at least one employee...</p>
        <p><i class="fa fa-check" aria-hidden="true"></i> <b>Step3.</b> Set up categories...</p>
        <p><i class="fa fa-check" aria-hidden="true"></i> <b>Step4.</b> Set up categories...</p>
    </div>
    <!-- текстовки необходимых справочников-->
    <div id="el_position_id">You should fill out "Positions" before work with this form</div>
    <div id="el_wage_scheme_id">You should fill out "Wage Schemes" before work with this form</div>
    <div id="el_e_wage_month">Please select month to calculate wage</div>

    <!-- текстовки боковой инфопанели-->
    <div id="sim_wage_rate">Info about wage_rate</div>
    <div id="sim_is_material_cost_counted">Info about is_material_cost_counted</div>
    <div id="sim_is_client_discount_counted">Info about is_client_discount_counted</div>
    <div id="sim_info_example">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</div>

</div>

<script>
    /**
     * Show modal window
     * @param text  - REQUIRED, window body. Can be text or object
     * @param data  - other data for modal. Be free to add own elements
     *              - title - window title
     *              - type  - modal/error/message/welcome
     *              - hideButtons - hide or show footer with buttons
     *              - buttonId - id for action button
     *              - buttonClass - class for action button
     */
    function showBiModal(text, data) {
        //checking params
        if (data === undefined) {
            data = {};
        }
        if (data['title'] === undefined ) {
            data['title'] = '';
        }
        if (data['type'] === undefined) {
            data['type'] = 'modal';
        }
        if (data['type'] != 'welcome' && text === undefined ) {
            return false;
        }

        //div-template to use
        var modalTpl = $('#biModal');

        // hiding title area if don't need
        if (data['title'] == ''){
            modalTpl.find('.modal-header').hide();
            modalTpl.find('.modal-header-empty').show();
        } else {
            modalTpl.find('.modal-header').show();
            modalTpl.find('.modal-header-empty').hide();
            modalTpl.find('.modal-title').html(data['title']);
        }

        // put window's text
        switch (data['type']) {
            case 'welcome':
                modalTpl.find('.modal-body').addClass('modal-body-welcome').html( $('#welcomeModal').html());
                break;
            case 'error':
            case 'message':
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
            if(data['type'] = 'welcome'){
                modalTpl.find('.modal-footer').hide();
                modalTpl.find('.modal-footer-welcome').show();
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
        }

        // init modal
        modalTpl.modal();

        // clear on hide
        modalTpl.on('hide.bs.modal', function (event) {
            var modal = $(this);
            // save welcome-window's checkbox staet
            if (modal.find('.modal-body').hasClass('modal-body-welcome')) {
                var show_welcome = $('.modal-dialog input[type=checkbox]').is(':checked');
                var organization_id = $('.modal-dialog #organization_id').val();

                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: '/organization/updateShowWelcome',
                    data: {show_welcome: show_welcome, organization_id: organization_id},
                    success: function(data) {
                        console.log(' Success saving show_welcome');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(' Error while saving show_welcome');
                    }
                });

            }
            // clear dialog element
            modal.find('.modal-title').html('');
            modal.find('.modal-body').removeClass('modal-body-welcome').html('');
        });
    }
    /**
     * shows side-modal panel with text-block
     * */
        //sideModalText
    function showSideModal(text) {
        // set content
        $('#sideModal').find('.modal-body').html(text);
        // init modal
        $('#sideModal').modal();
    }

    /**
     * отображение сообщения об ошибке в модальном окне
     * @param text
     */
    function showBiModalError(text) {
        $('#biModal .modal-body').prepend("<div class='alert alert-error visible'><i class='fa fa-info-circle'' aria-hidden='true'></i>"+ text + "</div>");
    }

    /**
     * отображение успешного сообщения в модальном окне
     * @param text
     */
    function showBiModalMessage(text) {
        $('#biModal .modal-body').prepend("<div class='alert alert-success visible'><i class='fa fa-info-circle'' aria-hidden='true'></i>"+ text + "</div>");
    }

    /**
     * check if important lists are empty and show info-window
     * @param lists
     */
    function checkZeroLists(lists){
        var infoItems = [];

        // checking if lists are empty
        for(var i=0; i < lists.length; i++){

            if ($('#'+lists[i]).length){
                // trying to match by id
                //console.log(lists[i]+' by ID');
                if ($('#'+lists[i]+'> option').length < 2){
                    infoItems.push(lists[i]);
                }
            } else {
                // trying to match by name
                //console.log(lists[i]+' by NAME');
                if ( $("select[name='" + lists[i] + "']").length ) {
                    if ($("select[name='" + lists[i] + "'] > option").length < 2) {
                        infoItems.push(lists[i]);
                    }
                }
            }
        }

        // if some of lists are empty - getting their info and show in modal
        if (infoItems.length > 0){
            var message = '';
            for(var j=0; j < infoItems.length; j++){
                console.log('#el_'+infoItems[j]);
                console.log( $('#el_'+infoItems[j]).html() );
                message += '<i class="fa fa-circle-thin" aria-hidden="true"></i> ' + $('#el_' + infoItems[j]).html()  + '<br>';
            }

            console.log(message);
            if (message != ''){
                showBiModal( message ,{
                    //title: '@lang('main.client:list_add_all_found_to_category')',
                    title: 'Barcelona HELP',
                    hideButtons: true
                });
            }
        }
    }
</script>
