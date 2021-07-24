<?php


namespace App\Http\Controllers;


use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController
{
    public function lookup(Request $request)
    {
        $title = $request->get('title');
        $bookList = DB::table('book')->where('title', 'like','%' . $title . '%')->get();
        return BookResource::collection($bookList);
    }
}