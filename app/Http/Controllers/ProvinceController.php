<?php


namespace App\Http\Controllers;


use App\Http\Resources\ProvinceResource;
use App\Models\Province;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::get()->sortBy('id')->all();
        return ProvinceResource::collection($provinces);
    }
}