<?php


namespace App\Http\Controllers;


use App\Constant;
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

    public function search(Request $request)
    {
        $title = $request->get('title');
        $category_id = $request->get('category_id');
        $bookQuery = Book::where('title', 'like','%' . $title . '%');

        if (!empty($category_id)) {
            $bookQuery->where('category_id', $category_id);
        }

        $bookList = $bookQuery->paginate(Constant::PAGE_SIZE);

        return BookResource::collection($bookList);
    }

    public function details(Request $request, int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            throw new \Exception('Book not found');
        }

        return new BookResource($book);
    }
}