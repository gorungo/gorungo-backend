<?php
/**
 * Created by PhpStorm.
 */
$temp_html = '<div style="text-align: center; font-size: 100px; color: #c4e7f9;"><span class="icomoon"></span></div>';
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="picture-uploader-wrap">
            <div class="picture-edit">{!! $temp_html !!}</div>
        </div>
        <form action="{{route($item->getTable() . '.upload_photo', $item->id)}}" id="form-upload" name="form_upload" target="upload-image" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="MAX_FILE_SIZE" value="9000000" />
            <input type="hidden" name="user_id" value="{{$item->user_id}}" />
            <input type="hidden" name="ajax" value="ajax" />
            <div class="file-upload bs">
                <span class="icomoon" style="font-size: 18px;"> </span> Добавить изображение
                <input type="file" name="file_img" id="file-uploader" accept="image/*" />
            </div>
        </form>
        <iframe id="upload-image" name="upload-image" style="width: 100%; display: none;" ></iframe>
        <div>Выберите фото и нажмите <img id="img_star" src="{{asset('images/interface/icos/ico_star.png')}}">, чтобы сделать изображение главным
        </div>
    </div>
</div>
@push('scripts')
<script>
    var controller = '{{$item->getTable()}}';

        updateImagesList({{$item->id}});


        $('#file-uploader').change(function () {

            document.form_upload.submit();
            if ($('#file-uploader').val() != '') {

                options = '<div class="adword_tmb_sml">' +
                    '<div class="ds-img-loading">&nbsp;</div>' +
                    '</div>';
                $('.picture-edit').html($('.picture-edit').html() + options);

                $('#form-upload').submit(function () {
                });


            }

        });

    function img_load(src) {
        src = src + '?rnd=' + randomNumber(100, 400000);


    }

    function img_infomess(state, item_id) {
        if (state == 'ok') {
            updateImagesList(item_id);

        }
        if (state == 'error') {
            updateImagesList(item_id);
            showInfoMessage('Ошибка при загрузке изображения', 'red');

        }

    }

    function updateImagesList(itemId) {

        if (itemId) {
            $.ajax({
                /* адрес файла-обработчика запроса */
                url: '/' + controller + '/' + itemId + '/photos',
                /* метод отправки данных */
                method: 'GET',

                dataType: 'JSON',

                /* что нужно сделать до отправки запрса */

                beforeSend: function () {

                },

                error: function () {
                    showInfoMessage('Ошибка при загрузке изображений', 'red');
                    $('.picture-edit').html(
                            '{!! $temp_html !!}'
                    );

                },

                success: function (result) {


                    var photos = '';
                    var sel_atr = '';
                    var i_count = 0;


                    if(result){
                        $(result).each(function () {
                            i_count ++;
                            var src = "/storage/images/" + controller + "/" + $(this).attr('item_id') + '/' + $(this).attr('img_name')
                            photos += '<div class="adword_tmb_sml">' +
                                '<div class="del_btn"  id="tab_image_' + $(this).attr('id') + '" ' +
                                'onclick="del_img(' + $(this).attr("id") + ');">' +
                                '<img src="/images/interface/icos/ico_del.png"/>' +
                                '</div>' +
                                '<div class="star_btn"  onclick="star_img(' + $(this).attr("id") + ');"><img src="/images/interface/icos/ico_star.png"></div>' +
                                '<div class="adword_tmb_sml_in">' +
                                '<img src="' + src + '" border=0 height="100%"/>' +
                                '</div></div>'


                        });

                        if(i_count>0){
                            $('.picture_edit').html(photos);
                        }else{
                            $('.picture_edit').html('{!! $temp_html !!}');
                        }

                    }else{

                    }



                    /* что нужно сделать по факту выполнения запроса */
                }
            })
        }
    }



    /*
     функция удаляет изображение
     */

    function del_img(img_id) {


        if ( img_id ) {
            $.ajax({
                /* адрес файла-обработчика запроса */
                url:  '/photos/delete_img',
                /* метод отправки данных */
                method: 'DELETE',

                dataType: 'JSON',

                /* данные, которые мы передаем в файл-обработчик */
                data: "img_id=" + img_id
                + "&controller=" + controller,


                beforeSend: function () {

                },

                success: function (result) {
                    if (result.type == 'error') {

                        return 'error';

                    } else {

                        // получаем информацию о содержимом каталога с изображениями
                        // обновляем список на странице

                        updateImagesList(result.item_id);

                    }
                }

            })
        }
    }

    /*
     * star_img  делает изображение главным
     * */

    function star_img( img_id) {
        if (img_id ) {

            $.ajax({
                /* адрес файла-обработчика запроса */
                url:  '/photos/star_img',
                /* метод отправки данных */
                method: 'POST',

                dataType: 'JSON',
                /* данные, которые мы передаем в файл-обработчик */
                data: "img_id=" + img_id
                + "&controller=" + controller,

                /* что нужно сделать до отправки запрса */

                beforeSend: function () {

                },

                success: function (result) {
                    if (result.type == 'error') {

                        My.display_info_message('Опс, ошибка при установке главного изображения.', 'red');
                    }
                    else {

                        //сообщение о положительном результате

                        showInfoMessage('Главное изображение установлено.', 'green');
                        updateImagesList(result.item_id);

                    }
                }

                /* что нужно сделать по факту выполнения запроса */
            })
        }
    }
</script>
@endpush

