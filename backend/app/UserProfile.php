<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = "user_profile";
    protected  $fillable = ['id','data_nasc','gender','about','phone','user_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
