<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Page;
use App\Action;
use App\Category;
use App\Http\Requests\UploadPhoto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAction;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{

    protected $page;
    protected $action;

    public function __construct(Action $action)
    {
        $this->action = $action;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $categoriesUrl = null)
    {
        $page = new Page();
        $page->title = __('action.title');

        $categoriesArray = null;
        $activeCategory = null;
        $categories = null;

        $categoriesArray = explode('/', $categoriesUrl);
        $activeCategoryTitle = last($categoriesArray);

        //$activeCategoryTitle = ($category3 !== Null) ? $category3 : Null;
        //$activeCategoryTitle = ($category2 !== Null && !$activeCategoryTitle) ? $category2 : Null;
        //$activeCategoryTitle = ($category1 !== Null && !$activeCategoryTitle) ? $category1 : Null;

        if ($activeCategoryTitle) {

            $activeCategory = Category::where('slug', $activeCategoryTitle)->first();

            if(!$activeCategory){
                abort('404');
            }

            // get category child for making links
            if ($activeCategory){
                $categories = Category::ChildCategory($activeCategory->id)->IsActive()->get();
            }
            if($categories->count() == 0){
                $categories = Category::ChildCategory($activeCategory->parent_id)->IsActive()->get();
            }



        } else {
            //$categories = Category::MainCategory()->IsActive()->get();
            $categories = Category::getMainCategories();
        }

        // get list of actions
        $actions = $this->action->itemsList($request, $activeCategory);

        return view('action.index', compact(['page', 'actions', 'categories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Idea $idea, Action $action)
    {
        return view('action.edit' , compact(['action', 'idea']));
    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @param  Idea $item
     * @return \Illuminate\Http\Response
     */
    public function show( $category, $itemSlug)
    {

        $item = Idea::where('slug', $itemSlug)->first();

        if(!$item){
            abort('404');
        }

        /*$breadcrumb_array = [
            ['title' => 'Главная', 'url' => route('home',  session('current_city_alias'))],
            ['title' => 'Товары', 'url' => route('products.list',[session('current_city_alias'),''])],
            ['title' => 'Новый товар',  'url' => '#'],
        ];*/

        return view('idea.show' , compact(['item', 'breadcrumb_array' ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Action $action
     * @return \Illuminate\Http\Response
     */
    public function edit(Action $action)
    {
        return view('action.edit',  compact(['action']));
    }



    /**
     * Return list of items photo
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPhotosListJson(){
        return response()->json($this->idea->ideaPhotos()->isActive()->get());
    }

    /**
     * Return list of items photo
     * @param UploadPhoto $request
     * @param $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhoto(UploadPhoto $request, $itemId){

        $idea = Idea::where('id', $itemId)->first();
        if($idea) return response()->json($idea->uploadPhoto($request));

        return response()->json(['type' => 'error', 'itemId' => $itemId]);
    }
}
