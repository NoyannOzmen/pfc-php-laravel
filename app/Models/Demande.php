<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Demande extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'demande';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'statut_demande',
        'date_debut',
        'date_fin',
    ];

        /**
     * Get animal informations
     */
    public function animal_accueillable(): BelongsTo
      {
        return $this->belongsTo(Animal::class, 'animal_id');
      }

    /**
     * Get foster family informations
     */
    public function potentiel_accueillant(): BelongsTo
      {
        return $this->belongsTo(Famille::class, 'famille_id');
      }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
