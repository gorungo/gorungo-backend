@extends ('layouts.app')

@section('title', htmlspecialchars($item->title) . ' - редактирование')

@section('header')
    @include('parts.header')
@endsection

@section('content')
    @include('widgets.breadcrumb')
    <div class="container" style="margin-top: 20px;">
        <div id="edit-title" class="clearfix">
            <h2 style="vertical-align:middle;" class="job_title">
                {{__('editor.edit_idea')}}
                <button class="pull-right btn btn-round btn-green" onclick="hasPageChanges = false; document.frm_form.submit();">{{__('editor.save_button')}}</button>
            </h2>
            @include('idea.widgets.locale_selector')
        </div>
        @include('widgets.error')
        <ul class="nav nav-pills">
            <li class="nav-item" role="presentation">
                <a id="pills-main-tab" data-toggle="pill" href="#pills-main" role="tab" aria-controls="pills-main" aria-selected="true" class="nav-link active"><span class="glyphicon glyphicon-pencil"> </span>{{__('editor.tab_main')}}</a>
            </li>
            <li class="nav-item" role="presentation">
                <a id="pills-photo-tab" data-toggle="pill" href="#pills-photo" role="tab" aria-controls="pills-photo" aria-selected="false" class="nav-link"><span class="glyphicon glyphicon-picture"> </span>{{__('editor.tab_pictures')}}</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            {{--main info--}}
            <div class="tab-pane fade show active" id="pills-main" role="tabpanel" aria-labelledby="pills-main-tab">
                <form action = "{{route('ideas.update',$item->slug )}}" name="frm_form" method="post">
                    {{csrf_field()}}
                    {!! method_field('patch') !!}
                    <input type="hidden" name="category_id" value="{{ $item->id or '0' }}"/>
                    <input type="hidden" name="author_id" value="{{ $item->author_id or '0' }}"/>
                    <input type="hidden" name="city_id" value="{{ $item->city_id or '4741' }}"/>
                @include('idea.forms.category_selector_fields')
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}" style="margin-top: 30px;">
                            <input type="radio" name="active" value="0" @if($item->active == 0) checked @endif  /><span style="margin-right: 12px;">{{__('editor.label_not_active')}}</span>
                            <input type="radio" name="active" value="1" @if($item->active == 1) checked @endif /><span>{{__('editor.label_active')}}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="frm_title">{{__('editor.label_title')}}</label>
                    <input class="form-control" type="text" maxlength="100" name="title" id="frm_title" value="@if(old('title')){{old('title')}}@else{{$item->title}}@endif"/>
                </div>

                <div class="form-group{{ $errors->has('intro') ? ' has-error' : '' }}">
                    <label for="frm_intro">{{__('editor.label_intro')}}</label>
                    <input class="form-control" type="text" maxlength="100" name="intro" id="frm_intro" value="@if(old('intro')){{old('intro')}}@else{{$item->intro}}@endif"/>
                </div>

                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="frm_description">{{__('editor.label_title')}}</label>
                    <textarea class="form-control" type="text"  name="description" id="frm_description" rows="10">{{old('description') ? old('description') : isset($item->description) ? $item->description : ''}}</textarea>
                    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
                    <script>
                        CKEDITOR.replace( 'frm_description' );
                    </script>
                </div>

                @include('idea.widgets.tags_selector')
                </form>
            </div>
            {{--picture editor--}}
            <div class="tab-pane" id="pills-photo" role="tabpanel" aria-labelledby="pills-photo-tab">
                <div id="photo-uploader-block">
                    <photo-uploader controller="ideas" item-id="{{$item->id}}"></photo-uploader>
                </div>
            </div>
            @include('idea.widgets.category_selector')
        </div>
    </div>
@endsection


@push('scripts')
    @include('js.input_check')

@endpush

