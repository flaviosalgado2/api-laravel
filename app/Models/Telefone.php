<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Telefone extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'numero'
    ];

    public function rules()
    {
        return [
            'cliente_id' => 'required',
            'numero' => 'required'
        ];
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
}
