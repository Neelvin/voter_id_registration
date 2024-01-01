<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityHistory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public function getCreatedAtAttribute($value)
    {
        $carbonDate = Carbon::parse($value);

        return $carbonDate->format('m/d/Y');
    }
}
