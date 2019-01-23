<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all()->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::findorfail($id)->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function fullCategoriesListing($categoryId){

        $category = Category::where('id', $categoryId)->isActive()->first();

        if($category){
            return $category->fullCategoriesListing($category);
        }else if($categoryId == 0){
            $parenCategoryList[] = Category::where('parent_id',$categoryId)->isActive()->get();
            return response()->json(['type'=>'ok', 'data'=>['parentCategoryList' => $parenCategoryList, 'categorySelected' => [0]]]);
        }else{
            return ['type' => 'error'];
        }


    }
    public function child($categoryId){

        $category = Category::where('id', $categoryId)->isActive()->first();
        return response()->json(Category::categoryChildrenJSON($category));

    }


}
