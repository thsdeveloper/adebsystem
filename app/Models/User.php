<?php

namespace App\Models;

use App\Post;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Laravel\Scout\Searchable;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use Notifiable;
    use HasRoles;
    use HasMediaTrait;
//    use Searchable;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_url',
    ];

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        $mediaProfiles = $this->getMedia('profile');
        if (count($mediaProfiles) > 0) {
            return $mediaProfiles[0]->getFullUrl();
        }
        return url('img/avatar-default.png');
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    //Retorna a tabela de detalhes daquele usuário
    public function details()
    {
        return $this->hasOne(UserDetail::class);
    }

    //Retorna os posts daquele usuário
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //Retorna os posts daquele usuário
    public function addresses()
    {
        return $this->belongsTo(Address::class);
    }

    public function isRoleAdmin()
    {
        return response()->json($this->hasRole('admin'));
    }

    public function departments()
    {
        return $this->belongsToMany(Departments::class, 'users_departments', 'user_id', 'department_id')->withTimestamps();
    }

    public function igreja()
    {
        return $this->belongsToMany(Igreja::class, 'users_igrejas', 'user_id', 'igreja_id')->withTimestamps();
    }

    public function trusts()
    {
        return $this->belongsToMany(Trust::class, 'user_trusts', 'user_id', 'trust_id')->withTimestamps();
    }

    public function getAllPermissionsAttribute() {
        $permissions = [];
//        dd(Auth::user()->can('secretaria.visitantes'));
        //secretaria.visitantes    //members.created
//        dd(Auth::user()->getPermissionNames(), Auth::user()->permissions());
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[] = $permission->name;
            }
        }
        return $permissions;
    }

    //Retorna os posts daquele usuário
    public function situacaoMembro()
    {
        return $this->hasOne(SituacoesMembro::class, 'id', 'status_id');
    }

    public function getMatriculaMembro(){
        do{
            $rand = $this->generateRandomString(8);
        }while(!empty($this->where('matricula', $rand)->first()));
        return $rand;
    }

    public function generateRandomString($length) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
