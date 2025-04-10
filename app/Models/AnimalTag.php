<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalTag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'animal_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'animal_id',
        'tag_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
