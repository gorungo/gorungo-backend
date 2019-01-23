@extends ('layouts.app')
@section('title', __('idea.new_idea'))

@section('header')
    @include('parts.header')
@endsection

@section('content')
    @include('widgets.breadcrumb')
    <div class="container" style="margin-top: 20px;">
        <div id="edit-title" class="clearfix">
            <h2 style="vertical-align:middle;" class="job_title">
                {{__('idea.create')}}
                <button class="pull-right btn btn-round btn-green" onclick="hasPageChanges = false; document.frm_form.submit();">{{__('editor.save_button')}}</button>
            </h2>
        </div>
        @include('widgets.error')
        <ul class="nav nav-tabs">
            <li role="presentation" id="tab_main" onclick="show_tab('tab_main','tab_main_block');" class="active"><a href="#"><span class="glyphicon glyphicon-pencil"> </span>{{__('editor.tab_main')}}</a></li>
            <li role="presentation" id="tab_photo" onclick="show_tab('tab_photo','tab_photo_block');" ><a href="#"><span class="glyphicon glyphicon-picture"> </span>{{__('editor.tab_pictures')}}</a></li>
        </ul>
        <div>
            <form action = "{{route('ideas.store')}}" name="frm_form" method="post">
                {{csrf_field()}}
                <div id="tab_main_block" class="active_block">
                    @include('idea.forms.category_selector_fields')
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}" style="margin-top: 30px;">
                                    <input type="radio" name="active" value="0" @if(old('active') == 0) checked @endif  /><span style="margin-right: 12px;">{{__('editor.label_not_active')}}</span>
                                    <input type="radio" name="active" value="1" @if(old('active') == 1) checked @endif /><span>{{__('editor.label_active')}}</span>
                                </div>
                            </div>
                        </div>
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="frm_title">{{__('editor.label_title')}}</label>
                        <input class="form-control" type="text" maxlength="100" name="title" id="frm_title" value="@if(old('title')){{old('title')}}@endif"/>
                    </div>
                    <div class="form-group{{ $errors->has('intro') ? ' has-error' : '' }}">
                        <label for="frm_intro">{{__('editor.label_intro')}}</label>
                        <input class="form-control" type="text" maxlength="199" name="intro" id="frm_intro" value="@if(old('intro')){{old('intro')}}@endif"/>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="frm_description">{{__('editor.label_title')}}</label>
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
            @include('idea.widgets.category_selector')
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('/js/category.js')}}"></script>
@endsection
@push('scripts')
    @include('js.input_check')
@endpush




