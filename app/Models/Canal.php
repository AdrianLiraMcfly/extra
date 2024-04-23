<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'user_id'];
    protected $table = 'canales';

    public function temas()
    {
        return $this->hasMany(Tema::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
