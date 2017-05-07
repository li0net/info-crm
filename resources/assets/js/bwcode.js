$(document).ready(function () {
    /** подгружаем нужные стили **/
    $('head').append('<link rel="stylesheet" href="http://infogroup.online/css/bwcode.css" type="text/css" />');
    // $('head').append('<link rel="stylesheet" href="http://localhost:8000/css/bwcode.css" type="text/css" />');

    /** ссылка-крестик, прячем виджет **/
    $('body').on('click', '#bw_block_close', function(){
        if ( $( "#bw_block" ).length ) {
            $( "#bw_block" ).hide();
        }
    });


    /** клик по ссылке открытия виджета **/
    $('body').on('click', '#bw_link', function(){
        // получаю из ссылки id суперорганизации
        var scId = $(this).data('id');
        if( scId == '' || scId == undefined || scId == false){
            // ошибка если не задано
            alert('Wrong data id of link!');
        } else {
            if ( $( "#bw_block" ).length ) {
                //елси виджет уже загружен - отображаем
                $( "#bw_block" ).show();
            } else {
                //елси виджет не загружен - создаём блок и подгружаем
                $('<div/>', {
                    id: 'bw_block'
                }).appendTo('body');
                $('<div/>', {
                    id: 'bw_frame_block'
                }).appendTo('#bw_block');
                $('<a/>', {
                    id: 'bw_block_close',
                    href: '#'
                }).prependTo('#bw_block');

                // высота экрана для фрейма
                var frameHeight = $( window ).height()-7;

                // ширина экрана для фрейма
                var frameWidth = ($( window ).width() < 500) ? $( window ).width() : '500';

                // положение кнопки закрытия виджета зависит от ширины экрана
                var closePosition = (frameWidth == 500) ? 510 : frameWidth-40;
                $( "#bw_block_close" ).css('right',closePosition+'px');

                $('<iframe/>', {
                    id: 'bw_frame',
                    frameBorder: 0,
                    // src: 'http://localhost:8000/api/v1/widget/show?sid='+scId,
                    src: '//infogroup.online/api/v1/widget/show?sid='+scId,
                    width: frameWidth+'px',
                    height: frameHeight+'px'
                }).appendTo('#bw_frame_block');
            }
        }
    });
});
