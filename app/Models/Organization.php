<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Organization extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
    	'name',
    	'phone',
    	'email',
    	'website',
    	'logo'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['logo_link'];

    /**
     * Get the model's logo_link.
     *
     * @return bool
     */
    public function getLogoLinkAttribute()
    {
        return $this->attributes['logo_link'] = $this->attributes['logo'] ? Storage::disk('uploads')->url($this->attributes['logo']) : $this->attributes['logo'];
    }

    /**
     * Get the relationship for the model.
     */
    public function person()
    {
        return $this->hasMany('App\Models\Person', 'organization_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
