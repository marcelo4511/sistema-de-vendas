<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Detail;
use Carbon\Carbon;
use DateTimeInterface;

class Sale extends Model
{
    protected $dates = ['created_at','updated_at'];

    protected $fillable = [
        'id',
        'dataVenda',
        'total',
        'client_id',
    ];

    protected $table = 'sales';

    public function detailsales(){
        return $this->hasMany(Detail::class);
    }

    public function clients()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function getFormattedDateAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['dataVenda']));
    }

    public function getTheJsonColumnAttribute($value)
{
    return json_decode($value, true);
}

    protected $appends = ['formattedDate'];
}
