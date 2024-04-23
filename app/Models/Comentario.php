<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $fillable = ['comentario', 'tema_id', 'user_id'];
    protected $table = 'comentarios';

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
