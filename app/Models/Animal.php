<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'animal';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'race',
        'couleur',
        'age',
        'sexe',
        'description',
        'statut',
    ];

    /**
     * Get the photos of the animal.
     */
    public function images_animal(): HasMany
      {
        return $this->hasMany(Media::class);
      }

    /**
     * Get the shelter that houses the animal.
     */
    public function refuge(): BelongsTo
      {
        return $this->belongsTo(Association::class, 'association_id');
      }

    /**
     * Get the animal's species.
     */
    public function espece(): BelongsTo
      {
        return $this->belongsTo(Espece::class, 'espece_id');
      }

    /**
     * Get the current foster family of the animal.
     */
    public function accueillant(): BelongsTo
      {
        return $this->belongsTo(Famille::class, 'famille_id');
      }

    /**
     * Get the tags defining the animal
     */
    public function tags(): BelongsToMany
      {
        return $this->belongsToMany(Tag::class, 'animal_tag', 'animal_id', 'tag_id');
      }

    /**
     * Get the list of potential foster families
     */
    public function requests(): BelongsToMany
      {
        return $this->belongToMany(Famille::class, 'demandes', 'animal_id', 'famille_id')->withPivot('statut_demande', 'date_debut', 'date_fin');
      }
    //! PIVOT NAME MIGHT BE PROBLEMATIC

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
