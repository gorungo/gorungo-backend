<?php

namespace App;

use App\Http\Requests\StoreCategory;
use App\Traits\PhotoTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\Cache;

use DB;

class Category extends Model
{
    use SoftDeletes;
    use PhotoTrait;

    protected $table = 'categories';

    protected $dates = ['deleted_at'];

    protected $fillable = [ 'author_id', 'parent_id', 'active', 'order', 'slug'];

    protected $with = ['localisedCategoryTitle', 'localisedCategoryDescription'];

    Public function getTitleAttribute(){
        if($this->localisedCategoryTitle != null) {
            return $this->localisedCategoryTitle->title;
        }else{
            return '';
        }

    }

    Public function getIntroAttribute(){
        if($this->localisedCategoryTitle != null){
            return $this->localisedCategoryTitle->intro;
        }else{
            return '';
        }

    }

    Public function getDescriptionAttribute(){
        if($this->localisedCategoryDescription != null){
            return $this->localisedCategoryDescription->description;
        }else{
            return '';
        }

    }

    /**
     * Get path to tmb img of category item
     * @return string
     */
    Public function getTmbImgPathAttribute(){

        $defaultTmb = 'images/interface/icons/category_tmb_placeholder.png';

        if($this->thmb_img != ''){
            //если есть картинка вакансии
            $src = 'storage/images/category/' . $this->id . '/' . htmlspecialchars(strip_tags($this->tmb_img));
        }else{
            //если есть картинка вакансии
            $src = $defaultTmb;
        }

        if(!file_exists($src)){
            $src = $defaultTmb;
        }

        return $src;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categoryAuthor()
    {
        return $this->belongsTo('App\User', 'author_id');
    }


    public function categoryTitles()
    {
        return $this->hasMany('App\CategoryTitle', 'category_id', 'id');
    }

    public function localisedCategoryTitle()
    {
        return $this->hasOne('App\CategoryTitle', 'category_id', 'id')->where('locale_id', LocaleMiddleware::getLocaleId());
    }


    public function categoryDescriptions()
    {
        return $this->hasMany('App\CategoryDescription', 'category_id', 'id');
    }

    public function localisedCategoryDescription()
    {
        return $this->hasOne('App\CategoryDescription', 'category_id', 'id')->where('locale_id', LocaleMiddleware::getLocaleId());
    }

    public function hasLocaleName($localeName){
        return $this->hasOne('App\CategoryTitle', 'category_id', 'id')->where('locale_id', LocaleMiddleware::getLocaleId($localeName))->count();
    }

    public function hasLocaleId($localeId){
        return $this->hasOne('App\CategoryTitle', 'category_id', 'id')->where('locale_id', $localeId)->count();

    }

    public function categoryMetas()
    {
        return $this->hasMany('App\CategoryMeta', 'category_id', 'id');
    }

    public function localisedCategoryMetas()
    {
        return $this->hasMany('App\CategoryMeta', 'category_id', 'id')->where('locale_id', LocaleMiddleware::getLocaleId());
    }

    public function categoryIdeas()
    {
        return $this->belongsToMany('App\Idea');
    }

    public function categoryParent(){
        return $this->belongsTo('App\Category', 'parent_id');

    }
    public function categoryChildrens(){
        return $this->hasMany('App\Category', 'parent_id');
    }



    /**
     * returns category path with subcategories
     * @return string
     */
    public function pathToCategory(){

        $category = $this;

        $path = Cache::remember('pathToCategory_' . $this->id, 1, function () use ($category){

            $path = '';

            if($category->id ){

                $path = $path . $category->slug;

                if(isset($category->parent)){
                    $path =  $category->parent->slug . '/' . $path  ;

                    if(isset($category->parent->parent)){
                        $path =  $category->parent->parent->slug . '/' . $path ;
                    }
                }

            }

            return $path;
        });


        return $path;

    }

    public static function categoryChildrenJSON($category = null)
    {


        if($category == null){
            $result = Category::isActive()->MainCategory()->get();

        }else{
            $result = Category::isActive()->ChildCategory($category->id)->get();

        }


        if(count($result)){
            return response()->json($result);
        }

        return response()->json(['type' => 'error']);
    }

    public function scopeChildCategory($query, $parent_id){
        return $query->where('parent_id', $parent_id);
    }

    public function CategoryFriends(){

        return  Category::where('parent_id', $this->parent_id)->isActive()->get();

    }

    /**
     * Запрашиваем списки категорий для отображения в выборе категории на фронте
     * @param Category $category
     * @return array
     */
    public function fullCategoriesListing(Category $category){

        $parenCategoryList1 = null;
        $parenCategoryList2 = null;
        $parenCategoryList3 = null;

        $parenCategoryList = null;

        $categorySelected3 = null;
        $categorySelected2 = null;
        $categorySelected1 = null;

        $categorySelected = null;

        if($category){
            $parenCategoryList1 = $category->CategoryFriends();
            $categorySelected1 = $category->id;
        }

        if(isset($category->parent_id) && $category->parent_id !== 0){
            $parenCategoryList2 = $category->parent->CategoryFriends();
            $categorySelected2 = $category->parent->id;
        }

        if(isset($category->parent->parent_id) && $category->parent->parent_id !== 0){
            $parenCategoryList3 = $category->parent->parent->CategoryFriends();
            $categorySelected3 = $category->parent->parent->id;
        }

        if($parenCategoryList3) $parenCategoryList[] = $parenCategoryList3;
        if($parenCategoryList2) $parenCategoryList[] = $parenCategoryList2;
        if($parenCategoryList1) $parenCategoryList[] = $parenCategoryList1;

        if($categorySelected3) $categorySelected[] = $categorySelected3;
        if($categorySelected2) $categorySelected[] = $categorySelected2;
        if($categorySelected1) $categorySelected[] = $categorySelected1;


        $result = ['parentCategoryList' => $parenCategoryList, 'categorySelected' => $categorySelected];

        return ['type' => 'ok', 'data' => $result];

    }

    public function allCategoryChildrenArray(){

        $subcategoryCashLifeTime = 10;
        $needCashe = true;

        $categoriesId = [];

            $categoriesId[] = $this->id;

            if(Cache::has('category_id_children_array_' . $this->id ) && $needCashe ){
                $categories_id = Cache::get('category_id_children_array_' . $this->id);
            }else{
                if(isset($this->categoryChildrens)){

                    foreach($this->categoryChildrens as $children){


                        if(isset($children->id)) $categoriesId[] = $children->id ;

                        if(isset($children->categoryChildrens)){

                            foreach($children->categoryChildrens as $children_children){


                                if(isset($children_children->id)){

                                    $categoriesId[] = $children_children->id ;
                                }

                            }
                        }


                    }
                }else{
                    $categoriesId[] = $this->id;
                }

                Cache::put('category_id_children_array_' . $this->id, $categoriesId, $subcategoryCashLifeTime);
            }


        return $categoriesId;


    }

    public function allCategoryParentArray(){

        $categories_id = [];
        $needCashe = true;

        if(Cache::has('products_category_id_parent_array_' . $this->id) && $needCashe ){
            $categories_id = Cache::get('products_category_id_parent_array_' . $this->id);
        }else{
            if(count($this->parent)){

                $parent = $this->parent;
                $categories_id[] = $parent->id;

                if(isset($parent->parent)){

                    $categories_id[] = $parent->parent->id ;

                }

                if(isset($parent->parent->parent)){

                    $categories_id[] = $parent->parent->parent->id ;

                }


            }else{
                $categories_id[] = 0;
            }

            Cache::put('products_category_id_parent_array_' . $this->id, $categories_id, 0);
        }

        return $categories_id;


    }

    /**
     * Creating a new category and storing in database
     * @param StoreCategory $request
     * @return null
     */
    public function createAndStore(StoreCategory $request){

        $localeId = LocaleMiddleware::getLocaleId();

        $categoryStoreData = $request->only( 'author_id', 'parent_id', 'active', 'order', 'slug' );
        $categoryTitleStoreData = $request->only( 'title', 'intro' );
        $categoryDescriptionStoreData = $request->only( 'description' );

        $categoryStoreData['parent_id'] = 0;

        // выбираем категорию для сохранения из подкатегорий
        if($request->has('category_id_3') && $request->category_id_3 != '0'){
            $categoryStoreData['parent_id'] = $request->category_id_3;

        }elseif($request->has('category_id_2') && $request->category_id_2 != '0'){
            $categoryStoreData['parent_id'] = $request->category_id_2;

        }elseif($request->has('category_id_1') && $request->category_id_1 != '0'){
            $categoryStoreData['parent_id'] = $request->category_id_1;

        }

        $categoryStoreData['author_id'] = 1;
        $categoryStoreData['slug'] = str_slug($request->title);

        $categoryTitleStoreData['locale_id'] = $localeId;
        $categoryDescriptionStoreData['locale_id'] = $localeId;


        $newCategory = DB::transaction(function () use ($categoryStoreData, $categoryTitleStoreData, $categoryDescriptionStoreData) {

            // saving new catgory data with transaction

            $newCategory = Category::create($categoryStoreData);

            if($newCategory){
                $newCategory->localisedCategoryTitle()->create($categoryTitleStoreData);
                $newCategory->localisedCategoryDescription()->create($categoryDescriptionStoreData);

            }else{
                return null;
            }

            return $newCategory;

        });

        return null;

    }

    /**
     * Updating category data
     * @param StoreCategory $request
     * @return mixed
     */
    function updateAndStore(StoreCategory $request){

        $localeId = LocaleMiddleware::getLocaleId();

        $categoryStoreData = $request->only( 'author_id', 'parent_id', 'active', 'order', 'slug' );
        $categoryTitleStoreData = $request->only( 'title', 'intro' );
        $categoryDescriptionStoreData = $request->only( 'description' );

        // выбираем категорию для сохранения из подкатегорий
        if($request->has('category_id_3') && $request->category_id_3 != '0' && $this->id != $request->category_id_3 ){
            $categoryStoreData['parent_id'] = $request->category_id_3;

        }elseif($request->has('category_id_2') && $request->category_id_2 != '0' && $this->id != $request->category_id_2 ){
            $categoryStoreData['parent_id'] = $request->category_id_2;

        }elseif($request->has('category_id_1') && $request->category_id_1 != '0' && $this->id != $request->category_id_1  ){
            $categoryStoreData['parent_id'] = $request->category_id_1;

        }

        $categoryStoreData['author_id'] = 1;
        //$categoryStoreData['slug'] = str_slug($request->title);

        $categoryTitleStoreData['locale_id'] = $localeId;
        $categoryDescriptionStoreData['locale_id'] = $localeId;

        $category = $this;

        $updateResult = DB::transaction(function () use ($category, $categoryStoreData, $categoryTitleStoreData, $categoryDescriptionStoreData) {

            // saving new catgory data with transaction

            $this->update($categoryStoreData);

            if(isset($this->localisedCategoryTitle()->first()->title)){
                $this->localisedCategoryTitle()->update($categoryTitleStoreData);
                $this->localisedCategoryDescription()->update($categoryDescriptionStoreData);
            }else{
                $this->localisedCategoryTitle()->create($categoryTitleStoreData);
                $this->localisedCategoryDescription()->create($categoryDescriptionStoreData);
            }


            return $category;

        });

        return $updateResult;

    }

    // scopes

    public function scopeMainCategory($query){
        return $query->where('parent_id', '0');
    }

    public function scopeWhereParentSlug($query, $parentSlug){

        $parentId = Category::where('slug', $parentSlug)->where('active', '1')->first();
        return $query->where('parent_id', $parentId);
    }

    public function scopeIsActive($query){
        return $query->where('active', '1');
    }


}
