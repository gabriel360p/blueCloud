<?php

//não esta dando certo pra criar uma pasta diretamente, então caso o usuário queira criar uma pasta, ele pode "criar" localmente (salva os dados no banco), a pasta só vai ser realmente criada 
//quando algum arquivo for enviado para a nuvem.

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Auth;
use Storage;
use App;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('folders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $result = \DB::table('folders')->where('user_id','=',Auth::id())->get();

        return view('folders.create',['folders'=>$result]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = \DB::table('folders')->where('name','like','%'.$request->name.'%')->get();

        if(sizeof($result)!=0){

            echo "Já tem uma pasta com esse nome";
            return back();
            
        }else{

            //"criando a pasta" - a pasta só vai ser realmente criada se o usuário adicionar algo.
            Folder::create([
                'name'=>$request->name,
                'user_id'=>Auth::id(),
                'user_root'=>Auth::user()->name,
            ]);

            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        //
    }
}
