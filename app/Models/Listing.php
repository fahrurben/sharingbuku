<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Listing
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Listing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Listing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Listing query()
 * @mixin \Eloquent
 */
class Listing extends Pivot
{
    const STATUS_AVAILABLE = 0;
    const STATUS_UNAVAILABLE = 1;

    protected $table = 'book_listing';

    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}