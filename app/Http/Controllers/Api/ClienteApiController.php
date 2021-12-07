<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class ClienteApiController extends Controller
{
    public function __construct(Cliente $cliente, Request $request)
    {
        $this->cliente = $cliente;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = $this->cliente->all();
        //dd($data); //
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, $this->cliente->rules());

        $dataForm = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $extension = $request->image->extension();

            $name = uniqid(date('His'));

            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm['image'])->resize(177, 236)->save(storage_path("app/public/clientes/$nameFile", 70));

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm['image'] = $nameFile;
            }
        }

        $data = $this->cliente->create($dataForm);

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = $this->cliente->find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if (!$data = $this->cliente->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado!'], 400);
        }

        $this->validate($request, $this->cliente->rules());

        $dataForm = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($data->image) {
                Storage::disk('public')->delete("/clientes/$data->image");
            }

            $extension = $request->image->extension();

            $name = uniqid(date('His'));

            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm['image'])->resize(177, 236)->save(storage_path("app/public/clientes/$nameFile", 70));

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm['image'] = $nameFile;
            }
        }

        $data->update($dataForm);

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (!$data = $this->cliente->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado!'], 400);
        }
        if ($data->image) {
            Storage::disk('public')->delete("/clientes/$data->image");
        }
        $data->delete();
        return response()->json(['success' => 'Deletado com sucesso!']);
    }
}
