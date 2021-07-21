<?php


namespace App\Http\Controllers;


use App\Http\Resources\ProvinceResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get()->sortBy('name')->all();
        return ProvinceResource::collection($categories);
    }
}