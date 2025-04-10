<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Association extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'association';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'responsable',
        'rue',
        'commune',
        'code_postal',
        'pays',
        'siret',
        'telephone',
        'site',
        'description'
    ];

    /**
     * Get the sheltered animals.
     */
    public function pensionnaires(): HasMany
      {
        return $this->hasMany(Animal::class);
      }
    /**
     * Get the pictures of the shelter.
     */
    public function images_association(): HasMany
      {
        return $this->hasMany(Media::class);
      }

    /**
     * Get the user associated with the shelter.
     */
    public function identifiant_association(): HasOne
      {
        return $this->hasOne(User::class, 'utilisateur_id');
      }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
