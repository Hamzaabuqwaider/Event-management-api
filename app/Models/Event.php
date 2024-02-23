<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Event
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Event extends Model
{

    use HasFactory;
    const ID = 'id';
    const USER_ID = 'user_id';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const START_TIME = 'start_time';
    const END_TIME = 'end_time';
    protected $table = 'events';

    protected $casts = [
        self::ID => 'int',
        self::USER_ID => 'int',
        self::NAME => 'string',
        self::DESCRIPTION => 'string',
        self::CREATED_AT => 'date',
        self::START_TIME => 'date',
        self::END_TIME => 'date',
        self::UPDATED_AT => 'date'
    ];

    protected $fillable = [
        self::NAME,
        self::USER_ID,
        self::DESCRIPTION,
        self::START_TIME,
        self::END_TIME
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
