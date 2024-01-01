<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTime;

class VoterProfile extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public function getCreatedAtAttribute($value)
    {
        $carbonDate = Carbon::parse($value);

        return $carbonDate->format('m/d/Y');
    }

    public function getAgeAttribute()
    {
        $dob = new DateTime($this->attributes['dob']);
        $currentDate = new DateTime();
        $diff = $dob->diff($currentDate);
        $age = $diff->y;
        
        return $age;
    }
}
