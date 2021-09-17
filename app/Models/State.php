<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'country_id' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];


    public function cities()
    {
        return $this->hasMany(\App\Models\City::class);
    }

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class);
    }
    public function users(){
        return $this->morphMany(User::class,'userable');
    }
}
