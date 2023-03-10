@extends ('layouts.app')
@section('title', 'новое блюдо')
@section('header')
    @include('parts.header')
@endsection

@section('content')
    @include('widgets.breadcrumb')
    <div class="container" style="margin-top: 20px;">
        <div id="edit-title" class="clearfix">
            <h2 style="vertical-align:middle;" class="job_title">
                {{__('general.edit_category')}}
                <button class="pull-right btn btn-round btn-green" onclick="hasPageChanges = false; document.frm_form.submit();">{{__('general.save_button')}}</button>
            </h2>
        </div>
        @include('widgets.error')
        <ul class="nav nav-tabs">
            <li role="presentation" id="tab_main" onclick="show_tab('tab_main','tab_main_block');" class="active"><a href="#"><span class="glyphicon glyphicon-pencil"> </span>{{__('general.tab_main')}}</a></li>
            <li role="presentation" id="tab_photo" onclick="show_tab('tab_photo','tab_photo_block');" ><a href="#"><span class="glyphicon glyphicon-picture"> </span>{{__('general.tab_pictures')}}</a></li>
        </ul>
        <div>
            <form action = "{{route('category.store')}}" name="frm_form" method="post">
                {{csrf_field()}}
                <div id="tab_main_block" class="active_block">
                         <div class="row" id="categories_block">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group{{ $errors->has('category_id_1') ? ' has-error' : '' }}">
                                    <label for="category_id_1">{{__('general.label_category')}}</label>
                                    <select name="category_id_1" id="cat_id_1" class="form-control">
                                        <option value="0">{{__('general.list_select_category')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group{{ $errors->has('category_id_2') ? ' has-error' : '' }}">
                                    <label for="category_id_2">{{__('general.label_subcategory')}}</label>
                                    <select name="category_id_2" id="cat_id_2" class="form-control">
                                        <option value="0">{{__('general.list_select_category')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group{{ $errors->has('category_id_3') ? ' has-error' : '' }}">
                                    <label for="category_id_3">{{__('general.label_subcategory')}}</label>
                                    <select name="category_id_3" id="cat_id_3" class="form-control">
                                        <option value="0">{{__('general.list_select_category')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}" style="margin-top: 30px;">
                                    <input type="radio" name="active" value="0" @if(old('active') == 0) checked @endif  /><span style="margin-right: 12px;">{{__('general.label_not_active')}}</span>
                                    <input type="radio" name="active" value="1" @if(old('active') == 1) checked @endif /><span>{{__('general.label_active')}}</span>
                                </div>
                            </div>
                        </div>
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="frm_title">{{__('general.label_title')}}</label>
                        <input class="form-control" type="text" maxlength="100" name="title" id="frm_title" value="@if(old('title')){{old('title')}}@endif"/>
                    </div>
                    <div class="form-group{{ $errors->has('intro') ? ' has-error' : '' }}">
                        <label for="frm_intro">{{__('general.label_intro')}}</label>
                        <input class="form-control" type="text" maxlength="199" name="intro" id="frm_intro" value="@if(old('intro')){{old('intro')}}@endif"/>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="frm_description">{{__('general.label_title')}}</label>
                        <textarea class="form-control" type="text"  name="description" id="frm_description" rows="8">@if(old('description')){{old('description')}}@endif</textarea>
                        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
                        <script>
                            CKEDITOR.replace( 'frm_description' );
                        </script>
                    </div>

                </div>
                <div id="tab_photo_block" style="display: none;">
                    <div style="text-align: center;">
                        <span class="icomoon" style="font-size: 100px; color: #c4e7f9;"></span>
                        <p>Для добавления фотографий сперва сохраните публикацию</p>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    @include('js.input_check')
    <script>
        $(document).ready(function () {
            //запрашиваем список основных категорий
            if (loadCategoryList(1, 0)) {

            }
            if (typeof cat_id_1 !== "undefined") {
                if (parseInt(cat_id_1) == cat_id_1 && cat_id_1 != 0) loadCategoryList(2, cat_id_1);
            }
            if (typeof cat_id_2 !== "undefined") {
                if (parseInt(cat_id_1) == cat_id_1 && cat_id_2 != 0) loadCategoryList(3, cat_id_2);
            }

            $('#cat_id_1').change(function () {

                // выбор категории и подгрузка подкатегорий
                var cat_id = $('#cat_id_1 :selected').val();

                if (cat_id == '0') {
                    $('#cat_id_2').html('<option value="0">выберите подраздел</option>');
                    $('#cat_id_2').attr('disabled', true);
                    $('#cat_id_3').html('<option value="0">выберите подраздел</option>');
                    $('#cat_id_3').attr('disabled', true);
                    $('#f_submit').attr('disabled', true);

                    return (false);
                }
                $('#cat_id_2').attr('disabled', true);
                $('#cat_id_2').html('<option>загрузка...</option>');

                loadCategoryList(2, cat_id);


            });
            $('#cat_id_2').change(function () {
                var cat_id = $('#cat_id_2 :selected').val();

                if (cat_id == '0') {

                    $('#cat_id_3').html('<option value="0">выберите подраздел</option>');
                    $('#cat_id_3').attr('disabled', true);
                    $('#cat_sel_3').hide();
                    $('#f_submit').attr('disabled', true);

                    return (false);
                }
                $('#cat_id_3').attr('disabled', true);
                $('#cat_id_3').html('<option>загрузка...</option>');

                loadCategoryList(3, cat_id);


            });
            $('#cat_id_3').change(function () {
                var cat_id = $('#cat_id_3 :selected').val();

                if (cat_id == '0') {
                    $('#f_submit').attr('disabled', true);
                    return (false);
                }


            });

        });



        function loadCategoryList(listId, cat_id) {
            var lastCat_id = 0;
            if (listId == 1) {
                listItem = '#cat_id_1';
                if (typeof cat_id_1 !== "undefined") {
                    lastCat_id = cat_id_1;
                }
            }
            if (listId == 2) {
                listItem = '#cat_id_2';
                if (typeof cat_id_2 !== "undefined") {
                    lastCat_id = cat_id_2;
                }
            }
            if (listId == 3) {
                listItem = '#cat_id_3';
                if (typeof cat_id_3 !== "undefined") {
                    lastCat_id = cat_id_3;
                }
            }



            $.ajax({
                /* адрес файла-обработчика запроса */
                url: '/api/categories/' + cat_id + '/child',
                /* метод отправки данных */
                method: 'GET',

                dataType: 'JSON',

                /* что нужно сделать до отправки запрса */

                beforeSend: function () {

                },

                success: function (result) {
                    if (result.type == 'error') {
                        $(listItem).html('<option>подразделы отсутствуют</option>');
                        $(listItem).attr('disabled', true);
                        $('#cat_sel_3').hide();
                        return(false);
                    }
                    else {
                        var options = '';
                        var cat_count=0;


                        $(result).each(function () {
                            sel_text = '';

                            if ($(this).attr('cat_id') == lastCat_id) sel_text = 'selected';

                            options += '<option value="' + this.id + '" ' + sel_text + '>' + this.localised_title.title + '</option>';
                            cat_count++;

                            console.log( this.localised_title.title);
                        });

                        if (listId == 1) {
                            $('#cat_id_1').html('<option value="0">Выберите категорию</option>' + options);
                            $('#cat_id_1').attr('disabled', false);
                            $('#cat_id_2').html('<option value="0">Выберите подкатегорию</option>');
                            $('#cat_id_2').attr('disabled', true);
                            $('#cat_id_3').html('<option>Выберите подкатегорию</option>');
                            $('#cat_id_3').attr('disabled', true);
                            $('#cat_sel_3').hide();


                        }
                        if (listId == 2) {
                            if(cat_count !=0 ){
                                $('#cat_id_2').html('<option value="0">Выберите подкатегорию</option>' + options);
                                $('#cat_id_2').attr('disabled', false);
                                $('#cat_id_3').html('<option value="0">Выберите подкатегорию</option>');
                                $('#cat_id_3').attr('disabled', true);
                                $('#f_submit').attr('disabled', true);
                            }
                        }
                        if (listId == 3) {
                            if(cat_count !=0 ){
                                $('#cat_id_3').html('<option value="0">Выберите подкатегорию</option>' + options);
                                $('#cat_id_3').attr('disabled', false);
                                $('#cat_sel_3').show();
                                $('#f_submit').attr('disabled', true);
                            }

                        }

                        return true;
                    }
                }
            })
        }

    </script>
@endpush




