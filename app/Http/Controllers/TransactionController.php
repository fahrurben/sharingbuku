<?php


namespace App\Http\Controllers;


use App\Http\Resources\TransactionResource;
use App\Models\Book;
use App\Models\Listing;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function request(Request $request)
    {
        $user = Auth::user();
        $book_id = $request->get('book_id');

        try {
            DB::beginTransaction();

            $book = Book::find($book_id);
            $listings = $book->availableListings;

            if (count($listings) === 0) {
                throw new \Exception('No book listing available');
            }

            $listing = $listings->first();

            $transaction = new Transaction();
            $transaction->requestor_id = $user->id;
            $transaction->listing_id = $listing->id;
            $transaction->status = Transaction::STATUS_REQUEST;
            $transaction->resolution = Transaction::RESOLUTION_NONE;
            $transaction->requested_at = new \DateTime();
            $transaction->save();

            $listing->status = Listing::STATUS_UNAVAILABLE;
            $listing->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new TransactionResource($transaction),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()],500);
        }
    }
}