<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Meal extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['title', 'description'];
    
    protected $fillable = ['status', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'meal_tag'); // Corrected here
    }
}
