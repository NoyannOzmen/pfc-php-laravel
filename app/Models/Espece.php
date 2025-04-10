<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Espece extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'espece';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom'
    ];

    /**
     * Get the animals belonging to the species.
     */
    public function specimens(): HasMany
      {
        return $this->hasMany(Animal::class);
      }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
