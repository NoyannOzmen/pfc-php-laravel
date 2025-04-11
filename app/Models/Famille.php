<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Famille extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'famille';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'prenom',
        'nom',
        'telephone',
        'rue',
        'commune',
        'code_postal',
        'pays',
        'hebergement',
        'terrain'
    ];

    /**
     * Get the fostered animals.
     */
    public function animaux_accueillis(): HasMany
      {
        return $this->hasMany(Animal::class);
      }

    /**
     * Get the list of potential fostered animals.
     */
    public function animal_accueillable(): BelongsToMany
      {
        return $this->belongsToMany(Animal::class, 'demandes', 'famille_id', 'animal_id')->withPivot('statut_demande', 'date_debut', 'date_fin');
      }

    /**
     * Get all requests made.
     */
    public function demandes(): HasMany
    {
        return $this->hasMany(Demande::class, 'famille_id');
    }

    /**
     * Get the user associated with the shelter.
     */
    public function identifiant_famille(): HasOne
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
