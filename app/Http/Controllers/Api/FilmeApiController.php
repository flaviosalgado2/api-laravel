<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MasterApiController;
use App\Models\Filme;
use Illuminate\Http\Request;

class FilmeApiController extends MasterApiController
{
    protected $model;
    protected $path = 'filmes';
    protected $upload = 'capa';
    protected $width = 800;
    protected $height = 533;

    public function __construct(Filme $filme, Request $request)
    {
        $this->model = $filme;
        $this->request = $request;
    }
}
