<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return HasMany<Section>
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'class_id');
    }
}
