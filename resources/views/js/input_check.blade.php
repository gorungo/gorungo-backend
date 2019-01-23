<script>
    // есть ли несохраненные данные
    var hasPageChanges = false;

    // только числа
    function formattingPrice( elem ){
        elem.value = elem.value.replace(/\D/g,'').substr(0,7);
    }

    $('.form-control').bind("change keyup input", function () {
        hasPageChanges = true;
    });

    //форматируем номер телефона
    function formattingNumbers( elem ) {

        if(elem.value !== ''){
            var num = elem.value.replace( /\D/g, '' ).split( /(?=.)/ ), i = num.length - 1;
            if ( 0 <= i ) num.unshift( '+ ' );
            if ( 1 <= i ) num.splice( 2, 0, ' ' );
            if ( 4 <= i ) num.splice( 6, 0, ' ' );
            if ( 7 <= i ) num.splice( 10, 0, '-' );
            if ( 9 <= i ) num.splice( 13, 0, '-' );
            elem.value = num.join( '' );
        }

    }

    function show_tab(tab, tab_id){

        if(!$('#'+tab).hasClass('active')){
            $('.active').removeClass('active');
            $('#'+tab_id).show();
            $('.active_block').hide();
            $('.active_block').removeClass('active_block');
            $('#'+tab).addClass('active');
            $('#'+tab_id).addClass('active_block');

            if(tab_id === 'tab_photo_block'){
                $('#submit_btn_block').hide();
            }else{
                if(!$('#submit_btn_block').is('visible')){
                    $('#submit_btn_block').show();
                }
            }
        }

    }



    $('#frm_form').submit(function() {
        $(window).unbind('beforeunload');
        $(window).off('beforeunload');
    });


    $(document).ready(function () {

        $('#btn_submit').on('click', function(){
            hasPageChanges = false;
        });

        $('a').on('click', function(){stopNavigate});

        $(document).on('submit', 'form', function(){
            hasPageChanges = false;
        });

    });

    function stopNavigate(event) {
        hasPageChanges = false;
        $(window).off('beforeunload');
    }

    function windowBeforeUnload() {
        if(hasPageChanges){
            return 'Are you sure you want to leave?';
        }

    }

    $(window).on('beforeunload', windowBeforeUnload);




</script>
