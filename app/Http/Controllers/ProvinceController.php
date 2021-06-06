<?php


namespace App\Http\Controllers;


use App\Models\Province;

class ProvinceController extends Controller
{
    public function index()
    {
        return Province::get()->sortBy('id')->all();
    }
}