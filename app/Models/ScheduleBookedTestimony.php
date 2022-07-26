<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleBookedTestimony extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'schedule_booked_testimony';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
