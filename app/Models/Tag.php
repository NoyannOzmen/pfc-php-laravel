<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'description'
    ];

    /**
     * Get the animals defined by the tag.
     */
    public function animaux_taggés(): BelongsToMany
      {
        return $this->belongsToMany(Animal::class, 'animal_tag', 'tag_id', 'animal_id');
      }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
