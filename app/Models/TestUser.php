<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestUser extends Model
{
    use HasFactory;

    protected $table = 'test_user';
    protected $guarded = false;

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function test() {
        return $this->belongsTo(Test::class);
    }
}
