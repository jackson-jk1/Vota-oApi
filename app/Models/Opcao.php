<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcao extends Model
{
    use HasFactory;
    protected $fillable = ['id_enquete','titulo','votos'];

    public function enquete()
    {
        return $this->belongsTo(Enquete::class, 'id_enquete','id');
    }
}
