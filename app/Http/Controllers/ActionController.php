<?php

namespace App\Http\Controllers;

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
    public function index(Request $request)
    {
        $categoriesUrl = '';
        $page = new Page();
        $page->title = __('action.title');

        // get list of actions
        $items = $this->action->itemsList($request);
        return view('action.index', compact(['page', 'items', 'categoriesUrl']));
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


        return view('idea.create' , compact(['categories', 'breadcrumb_array']));
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
     * @param  Idea $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        $item = $idea;
        $tagInfo = $item->getTagInfo();


        /*$breadcrumb_array = [
            ['title' => 'Главная', 'url' => route('home',  session('current_city_alias'))],
            ['title' => 'Товары', 'url' => route('products.list',[session('current_city_alias'),''])],
            ['title' => 'Редактирование товара',  'url' => '#'],
        ];*/


        return view('idea.edit',  compact(['item' ,'tagInfo' , 'breadcrumb_array']));
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
