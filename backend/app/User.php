<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable 
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type_user_id'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function tipo_usuario()
    {
        return $this->belongsTo(TypeUser::class,'type_user_id');
    }

    public function profile() 
    {
        return $this->hasOne(UserProfile::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function movimentacao()
    {
        return $this->hasMany(Movimentacao::class);
    }

    public function billstopay()
    {
        return $this->hasMany(BillsToPay::class);
    }
}
