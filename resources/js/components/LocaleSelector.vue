<template>
    <div id="category-selector" class="clearfix">
        <div class="row">
            <div class="col-xs-12">Специализации</div>
            <div class="col-md-4 col-sm-6 col-xs-12" v-for="(category, index) in item_categories" :id="'category-item-' + index">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <input type="hidden" :name="'categories[' + index + '][id]'" :value="category.id"/>
                        {{category.title}}<span class="icomoon btn-edit" v-on:click="editCategoryModalShow( category.id )"> </span>
                        <span :dusk="'remove_category_' + index" type="button" class="close" v-on:click="removeCategory( index )">&times;</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="category-item_add-btn" dusk="addcategory" v-on:click="addCategoryModalShow()" class="btn btn-primary pull-right"><span class="icomoon"> </span>Добавить</div>
        <div v-if="categories.length">
            <div class="modal fade" id="category-edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h3 class="modal-title" id="myModalLabel">
                                <span v-if="categoryEdit.mode === 'new'">Добавление категории</span>
                                <span v-if="categoryEdit.mode === 'edit'">Редактирование категории</span>
                            </h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="frm_category-id">Категория</label>
                                <select id="frm_category-id" name="category_id"  class="form-control" v-model="categoryEdit.categoryId">
                                    <option v-for="category in categories" :value="category.id" >{{category.title}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" v-on:click="categoryEdit.categoryId = null">Отмена</button>
                            <button type="button" dusk="addcategorymodal" v-if="categoryEdit.mode === 'new'" class="btn btn-primary" v-on:click="addCategory" >Добавить</button>
                            <button type="button" v-if="categoryEdit.mode === 'edit'" class="btn btn-primary" v-on:click="updateCategory" >Обновить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LocaleSelector",

//------DATA-----------------------------------------------------------------------------------------------

        data(){
            return {
                loading: false,

                categoryEdit:{
                    mode: 'new', // new or edit
                    categoryId: null,
                    itemCategoryIndex: null,
                },

            }
        },

//------PROPERTIES-----------------------------------------------------------------------------------------------

        props: ['item_categories', 'categories'],

//------METHODS-----------------------------------------------------------------------------------------------

        methods: {

            addCategoryModalShow: function(){

                this.categoryEdit.categoryId = this.categories[0].id;
                this.categoryEdit.mode = 'new';

                let modal = $('#category-edit_modal');
                modal.modal('show');
                modal.on('shown.bs.modal', function () {

                })
            },

            editCategoryModalShow: function(categoryId){

                this.categoryEdit.categoryId = categoryId;
                this.categoryEdit.mode = 'edit';

                let categories = Array.from(this.item_categories);
                let categoryIndex = 0;

                categories.forEach( category => {
                    if(category.id === this.categoryEdit.categoryId){
                        this.categoryEdit.itemCategoryIndex = categoryIndex;
                    }
                    categoryIndex++;
                });

                let modal = $('#category-edit_modal');
                modal.modal('show');
                modal.on('shown.bs.modal', function () {

                })
            },

            addCategory: function(){

                let categories = Array.from(this.categories);

                categories.forEach( category => {

                    if(category.id === this.categoryEdit.categoryId){
                        this.item_categories.push({
                            id: category.id,
                            title: category.title,
                        });
                    }
                });

                let modal = $('#category-edit_modal');
                modal.modal('hide');

                this.categoryEdit.categoryId = null;

            },

            updateCategory: function(){

                let categories = Array.from(this.categories);

                categories.forEach( category => {

                    if(category.id === this.categoryEdit.categoryId){
                        this.item_categories[this.categoryEdit.itemCategoryIndex].id = category.id;
                        this.item_categories[this.categoryEdit.itemCategoryIndex].title = category.title;
                    }
                });

                let modal = $('#category-edit_modal');
                modal.modal('hide');

                this.categoryEdit.categoryId = null;

            },

            removeCategory: function(index){
                if(this.item_categories.length > 1){
                    this.item_categories.splice(index,1);
                }else{
                    My.display_info_message('Нельзя удалить последнюю специализацию', 'green');
                }

            },

        },

//------COMPUTED-----------------------------------------------------------------------------------------------


    }
</script>

<style scoped>

</style>