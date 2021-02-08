<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id',
    	'name',
    	'email',
    	'phone',
    	'avatar'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avatar_link'];

    /**
     * Get the model's avatar_link.
     *
     * @return bool
     */
    public function getAvatarLinkAttribute()
    {
        return $this->attributes['avatar_link'] = $this->attributes['avatar'] ? Storage::disk('uploads')->url($this->attributes['avatar']) : $this->attributes['avatar'];
    }

    /**
     * Get the relationship for the model.
     */
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }
}
