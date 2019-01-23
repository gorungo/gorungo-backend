<div class="modal fade" id="category-selector-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div style="display:none;" id="category-editing-id"></div>
    <div style="display:none;" id="category-editing-index"></div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('editor.list_select_category')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group{{ $errors->has('category_id_1') ? ' has-error' : '' }}">
                            <label for="category_id_1">{{__('editor.label_category')}}</label>
                            <select name="category_id_1" id="cat_id_1" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group{{ $errors->has('product_category_id_2') ? ' has-error' : '' }}">
                            <label for="category_id_2">{{__('editor.label_subcategory')}}</label>
                            <select name="category_id_2" id="cat_id_2" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group{{ $errors->has('product_category_id_3') ? ' has-error' : '' }}">
                            <label for="category_id_3">{{__('editor.label_subcategory')}}</label>
                            <select name="category_id_3" id="cat_id_3" class="form-control">
                                <option value="0">{{__('editor.list_select_category')}}</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('editor.close_button')}}</button>
                <button type="button" class="btn btn-primary" onclick="saveCategory();">{{__('editor.save_button')}}</button>
            </div>
        </div>
    </div>
</div>