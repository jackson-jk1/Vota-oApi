<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquete extends Model
{
    use HasFactory;
    const ATIVO = 'A';
    const FINALIZADA = 'F';
    const NOVA = 'O';

    protected $fillable = ['id_user','titulo','inicio','fim','respostas','status'];

    public function opcoes()
    {
        return $this->hasMany(Opcao::class,'id_enquete','id');
    }
}
