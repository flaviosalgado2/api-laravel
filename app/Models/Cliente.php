<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'image'
    ];

    public function rules()
    {
        return [
            'nome' => 'required',
            'image' => 'image'
        ];
    }

    public function arquivo($id)
    {
        $data = $this->find($id);
        return $data->image;
    }

    public function documento()
    {
        return $this->hasOne(Documento::class, 'cliente_id', 'id');
    }
}
