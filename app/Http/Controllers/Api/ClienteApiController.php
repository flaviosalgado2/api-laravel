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
    protected $width = 177;
    protected $height = 236;
    protected $totalPage = 20;

    public function __construct(Cliente $clientes, Request $request)
    {
        $this->model = $clientes;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //sobreescrita de metodo na classe pai
        $data = $this->model->paginate($this->totalPage);
        //dd($data); //
        return response()->json($data);
    }

    public function documento($id)
    {
        if (!$data = $this->model->with('documento')->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado!'], 404);
        } else {
            return response()->json($data);
        }
    }

    public function telefone($id)
    {
        if (!$data = $this->model->with('telefone')->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado!'], 404);
        } else {
            return response()->json($data);
        }
    }

    public function alugados($id)
    {
        if (!$data = $this->model->with('filmesAlugados')->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado!'], 404);
        } else {
            return response()->json($data);
        }
    }
}
