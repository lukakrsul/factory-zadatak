<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['meal_id', 'locale', 'title', 'description'];

    public $timestamps = false;
}
