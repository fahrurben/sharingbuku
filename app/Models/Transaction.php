<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $requestor_id
 * @property int $listing_id
 * @property int $status
 * @property int $resolution
 * @property string|null $send_receipt
 * @property string|null $send_back_receipt
 * @property string|null $requested_at
 * @property string|null $approved_at
 * @property string|null $sent_at
 * @property string|null $received_at
 * @property string|null $sent_back_at
 * @property string|null $received_back_at
 * @property-read \App\Models\Listing $listing
 * @property-read \App\Models\User $requestor
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReceivedBackAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRequestorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereResolution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSendBackReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSendReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSentBackAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    const STATUS_REQUEST = 0;
    const STATUS_APPROVED = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_REJECTED = 3;
    const STATUS_SENDING = 4;
    const STATUS_RECEIVED = 5;
    const STATUS_SENDING_BACK = 6;
    const STATUS_RECEIVED_BACK = 7;

    const RESOLUTION_NONE = 0;
    const RESOLUTION_FINISHED = 1;
    const RESOLUTION_CANCELLED = 2;
    const RESOLUTION_REJECTED = 3;
    const RESOLUTION_UN_FINISHED = 4;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requestor_id',
        'listing_id',
        'status',
        'resolution',
        'send_receipt',
        'send_back_receipt',
        'requested_at',
        'approved_at',
        'sent_at',
        'received_at',
        'sent_back_at',
        'received_back_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'sent_at' => 'datetime',
        'received_at' => 'datetime',
        'sent_back_at' => 'datetime',
        'received_back_at' => 'datetime',
    ];

    public function requestor() {
        return $this->belongsTo(User::class);
    }

    public function listing() {
        return $this->belongsTo(Listing::class);
    }
}