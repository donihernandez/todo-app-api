<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'task_id',
        'name',
        'color'
    ];

    /**
     * @return BelongsTo
     */
    public function task(): BelongsTo {
        return $this->belongsTo(Task::class);
    }
}
