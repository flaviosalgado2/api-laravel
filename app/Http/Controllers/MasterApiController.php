<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class MasterApiController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model->paginate(10);
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
        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if ($request->hasFile($this->upload) && $request->file($this->upload)->isValid()) {
            $extension = $request->file($this->upload)->extension();

            $name = uniqid(date('His'));

            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm[$this->upload])->resize($this->width, $this->heigth)->save(storage_path("app/public/{$this->path}/$nameFile", 70));

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm[$this->upload] = $nameFile;
            }
        }

        $data = $this->model->create($dataForm);

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
        if (!$data = $this->model->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado!'], 404);
        } else {
            return response()->json($data);
        }
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
        if (!$data = $this->model->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado!'], 400);
        }

        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if ($request->hasFile($this->upload) && $request->file($this->upload)->isValid()) {
            $arquivo = $this->model->arquivo($id);
            if ($data->image) {
                Storage::disk('public')->delete("/{$this->path}/$arquivo");
            }

            $extension = $request->file($this->upload)->extension();

            $name = uniqid(date('His'));

            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm[$this->upload])->resize($this->width, $this->heigth)->save(storage_path("app/public/{$this->path}/$nameFile", 70));

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm[$this->upload] = $nameFile;
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
        if ($data = $this->model->find($id)) {
            if (method_exists($this->model, 'arquivo')) {
                Storage::disk('public')->delete("/{$this->path}/{$this->model->arquivo($id)}");
            }
            $data->delete();
            return response()->json(['success' => 'Deletado com sucesso!']);
        } else {
            return response()->json(['error' => 'Nada foi encontrado!'], 400);
        }
    }
}
