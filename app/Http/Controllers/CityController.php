<?php


namespace App\Http\Controllers;


use App\Http\Resources\CityResource;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cities =  City::get()->sortBy('id')->all();
        return CityResource::collection($cities);
    }

    public function getByProvince($province_id)
    {
        $cities =  City::where(['province_id' => $province_id])->get()->sortBy('id')->all();
        return CityResource::collection($cities);
    }
}