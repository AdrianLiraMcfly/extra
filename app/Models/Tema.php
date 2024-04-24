<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'canal_id', 'user_id'];
    protected $table = 'temas';

    public function canal()
    {
        return $this->belongsTo(Canal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
