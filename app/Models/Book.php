<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $author
 * @property int $category_id
 * @property string|null $isbn
 * @property int|null $image
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedBy($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $owners
 * @property-read int|null $owners_count
 */
class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'author',
        'category_id',
        'isbn',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function owners()
    {
        return $this->belongsToMany(User::class, 'book_listing', 'book_id', 'user_id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'book_id');
    }

    public function availableListings()
    {
        return $this->hasMany(Listing::class, 'book_id')->where('status', '=', Listing::STATUS_AVAILABLE);
    }

    /**
     * Get the book availability
     *
     * @return boolean
     */
    public function getIsAvailableAttribute()
    {
        return count($this->availableListings) > 0;
    }

    public function getIsLoggedInUserOwnedAttribute()
    {
        $user_id = (Auth::user())->id;
        return Listing::where('user_id', $user_id)->where('book_id', $this->id)->count() > 0;
    }
}
