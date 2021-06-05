<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lookup
 *
 * @property int $id
 * @property int $type
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lookup whereValue($value)
 * @mixin \Eloquent
 */
class Lookup extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lookup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'key',
        'value',
    ];
}
