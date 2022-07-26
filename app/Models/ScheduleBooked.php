<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleBooked extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasMany(ScheduleBookedDetail::class);
    }

    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }
}
