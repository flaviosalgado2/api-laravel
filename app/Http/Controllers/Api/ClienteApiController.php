<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MasterApiController;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteApiController extends MasterApiController
{
    protected $model;
    protected $path = 'clientes';
    protected $upload = 'image';

    public function __construct(Cliente $clientes, Request $request)
    {
        $this->model = $clientes;
        $this->request = $request;
    }

    public function documento($id)
    {
        if (!$data = $this->model->with('documento')->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado!'], 404);
        } else {
            return response()->json($data);
        }
    }
}
