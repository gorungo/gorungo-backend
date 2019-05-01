<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Category;
use App\Http\Requests\UploadPhoto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIdea;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\DB;

class IdeaController extends Controller
{

    protected $idea;

    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param String $categoriesUrl
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $categoriesUrl = null)
    {
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

        // get list of ideas
        $ideas = Idea::itemsList($request, $activeCategory);

        return view('idea.index', compact(['ideas', 'categories', 'categoriesUrl']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('idea.edit' , ['idea']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreIdea $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIdea $request, Idea $idea)
    {

        $idea = $idea->createAndSync($request);

        if($idea){

            return redirect()->route('ideas.edit', $idea->slug )->with('status', __('idea.created'));

        }else{

            return redirect()->back()->withInput()->with('status', __('idea.not_created'));

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @param  String $itemSlug
     * @return \Illuminate\Http\Response
     */
    public function show( $category, $itemSlug)
    {

        $item = Idea::where('slug', $itemSlug)->first();
        $ideaActions = $item->actionItemsList(4);

        if(!$item){
            abort('404');
        }

        /*$breadcrumb_array = [
            ['title' => 'Главная', 'url' => route('home',  session('current_city_alias'))],
            ['title' => 'Товары', 'url' => route('products.list',[session('current_city_alias'),''])],
            ['title' => 'Новый товар',  'url' => '#'],
        ];*/

        return view('idea.show' , compact(['item', 'category', 'ideaActions', 'breadcrumb_array' ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Idea $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        return view('idea.edit',  compact(['idea']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreIdea $request
     * @param  Idea $idea
     * @return \Illuminate\Http\Response
     */
    public function update(StoreIdea $request, Idea $idea)
    {

        $updateResult = $idea->updateAndSync($request);

        if($updateResult){
            // очищаем старый кэш
            //Cache::forget('category-all');
            //Cache::forget('category-widget');

            return redirect()->back()->with('status', __('idea.updated'));

        }else{
            return redirect()->back()->with('status', __('idea.not_updated'));

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
