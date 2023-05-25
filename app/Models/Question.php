<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $guarded = false;

    public function answers() {
        return $this->hasMany(Answer::class, 'quest_id');
    }
    public function questType() {
        return $this->belongsTo(TypeQuest::class);
    }

}
