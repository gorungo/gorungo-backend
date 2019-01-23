<?php

namespace App\Http\Controllers;

use App\CategoryTitle;
use App\CategoryDescription;
use App\Http\Requests\StoreCategory;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\LocaleMiddleware;

class CategoryController extends Controller
{

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // getting categories
        $categories = Category::get();


        /*$breadcrumb_array = [
            ['title' => 'Главная', 'url' => route('home',  session('current_city_alias'))],
            ['title' => 'Товары', 'url' => route('products.list',[session('current_city_alias'),''])],
            ['title' => 'Новый товар',  'url' => '#'],
        ];*/


        return view('category.create' , compact(['categories','breadcrumb_array' ]));
    }

    /**
     * Store new resourse Data
     * @param StoreCategory $request
     * @param Category $category
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategory $request, Category $category)
    {

        $newCategory = $category->createAndStore($request);

        if($newCategory){
            // очищаем старый кэш
            //Cache::forget('category-all');
            //Cache::forget('category-widget');

            return redirect()->route('category.edit', $newCategory->slug )->with('status', __('category.created'));

        }else{
            return redirect()->back()->withInput()->with('status', __('category.not_created'));

        }



    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('category.create' , compact(['categories','breadcrumb_array' ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $item = $category;

        $categories1 = []; $categories2 = []; $categories3 = [];

        $category_id_1 = 0; $category_id_2 = 0; $category_id_3 = 0;

        $contacts = Null;

        // getting categories
        $categories1 = Category::MainCategory()->isActive()->get();

        $item_category1 = $item;

        $categories_id = $category->allCategoryParentArray();


        if(count($categories_id) == 2){
            $category_id_3 = $item_category1->id;
            $category_id_2 = $categories_id[0];
            $category_id_1 = $categories_id[1];

            $categories3 = Category::isActive()->where('parent_id',$categories_id[0])->get();
            $categories2 = Category::isActive()->where('parent_id',$categories_id[1])->get();


        }elseif(count($categories_id) == 1){
            $category_id_2 = $item_category1->id;
            $category_id_1 = $categories_id[0];


            $categories1 = $categories1;
            $categories2 = Category::isActive()->where('parent_id',$categories_id[0])->get();
            $categories3 = Category::isActive()->where('parent_id',$item_category1->id)->get();


        }elseif(count($categories_id) == 0){
            $category_id_1 = 0;

        }

        $item->category_id_3 = $category_id_3;
        $item->category_id_2 = $category_id_2;
        $item->category_id_1 = $category_id_1;

        /*$breadcrumb_array = [
            ['title' => 'Главная', 'url' => route('home',  session('current_city_alias'))],
            ['title' => 'Товары', 'url' => route('products.list',[session('current_city_alias'),''])],
            ['title' => 'Редактирование товара',  'url' => '#'],
        ];*/


        return view('category.edit',  compact(['item' , 'categories1', 'categories2', 'categories3','breadcrumb_array']));

    }

    /**
     * Updating data
     * @param StoreCategory $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreCategory $request, Category $category)
    {
        $updateResult = $category->updateAndStore($request);

        if($updateResult){
            // очищаем старый кэш
            //Cache::forget('category-all');
            //Cache::forget('category-widget');

            return redirect()->back()->withInput()->with('status', __('category.updated'));

        }else{
            return redirect()->back()->with('status', __('category.not_updated'));

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}
