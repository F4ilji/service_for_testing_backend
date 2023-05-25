<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function questions() {
        return $this->hasMany(Question::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
