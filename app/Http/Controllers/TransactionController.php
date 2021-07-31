<?php


namespace App\Http\Controllers;


use App\Constant;
use App\Http\Resources\TransactionResource;
use App\Models\Book;
use App\Models\Listing;
use App\Models\Transaction;
use App\Models\User;
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

            if ($user->balance < Constant::BOOK_POINT_DEFAULT) {
                throw new \Exception('Your balance is not enough to borrow this book');
            }

            $listing = $listings->first();

            $transaction = new Transaction();
            $transaction->requestor_id = $user->id;
            $transaction->listing_id = $listing->id;
            $transaction->status = Transaction::STATUS_REQUEST;
            $transaction->resolution = Transaction::RESOLUTION_NONE;
            $transaction->requested_at = new \DateTime();
            $transaction->point = Constant::BOOK_POINT_DEFAULT;
            $transaction->save();

            $listing->status = Listing::STATUS_UNAVAILABLE;
            $listing->save();

            $requestor = $transaction->requestor;
            $requestor->balance -= $transaction->point;
            $requestor->save();

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

    public function cancel(Request $request)
    {
        $user = Auth::user();
        $transaction_id = $request->get('transaction_id');

        try {
            DB::beginTransaction();

            $transaction = Transaction::find($transaction_id);

            if ($transaction->requestor_id !== $user->id) {
                throw new \Exception('Action not permitted');
            }
            $transaction->status = Transaction::STATUS_CANCELLED;
            $transaction->resolution = Transaction::RESOLUTION_CANCELLED;
            $transaction->point = 0;
            $transaction->save();

            $listing = $transaction->listing;
            $listing->status = Listing::STATUS_AVAILABLE;
            $listing->save();

            $requestor = $transaction->requestor;
            $requestor->balance += $transaction->point;
            $requestor->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()],500);
        }
    }

    public function approve(Request $request)
    {
        $user = Auth::user();
        $transaction_id = $request->get('transaction_id');

        try {
            DB::beginTransaction();

            $transaction = Transaction::find($transaction_id);

            if ($transaction->listing->user_id !== $user->id) {
                throw new \Exception('Action not permitted');
            }

            $transaction->status = Transaction::STATUS_APPROVED;
            $transaction->resolution = Transaction::RESOLUTION_UN_FINISHED;
            $transaction->approved_at = new \DateTime();
            $transaction->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()],500);
        }
    }

    public function reject(Request $request)
    {
        $user = Auth::user();
        $transaction_id = $request->get('transaction_id');

        try {
            DB::beginTransaction();

            $transaction = Transaction::find($transaction_id);

            if ($transaction->listing->user_id !== $user->id) {
                throw new \Exception('Action not permitted');
            }

            $transaction_point = $transaction->point;
            $transaction->status = Transaction::STATUS_REJECTED;
            $transaction->resolution = Transaction::RESOLUTION_REJECTED;
            $transaction->approved_at = new \DateTime();
            $transaction->save();

            $listing = $transaction->listing;
            $listing->status = Listing::STATUS_AVAILABLE;
            $listing->save();

            $requestor = $transaction->requestor;
            $requestor->balance += $transaction_point;
            $requestor->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()],500);
        }
    }
}