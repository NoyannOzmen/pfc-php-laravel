<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'url',
        'ordre'
    ];

    /**
     * Get the animal shown in picture.
     */
    public function animal(): BelongsTo
      {
        return $this->belongsTo(Animal::class, 'animal_id');
      }

    /**
     * Get the shelter represented by logo.
     */
    public function refuge(): BelongsTo
      {
        return $this->belongsTo(Association::class, 'association_id');
      }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
