<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reputation_history extends Model {
    protected static $unguarded = true;

    public function user_id(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

}

