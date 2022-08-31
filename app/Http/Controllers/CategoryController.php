<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Video;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::paginate(5);
    }

    public function show(int $category)
    {
        $category = Category::find($category);
        if(is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return $category;
    }

    public function store(StoreCategoryRequest $request)
    {
        return Category::create($request->all());
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $category->save();

        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }

    public function categoryWithVideos(int $id)
    {
        $category = Category::find($id);
        if(is_null($category)) {
            return response()->json(['message' => 'Category not found']);
        }

        $videos = Video::where('category_id', $id)->paginate(5);

        return response([$category, $videos]);
    }

}
