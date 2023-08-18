@extends('layouts.master')



@section('body-content')

	<h1>Movendo Arquivo</h1>

    <div class="container">


        <div class="row">

            <div class="col">

                <form action="{{url('/files/move',$file->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <a href="{{Storage::disk('s3')->url($file->path)}}">Arquivo a ser movido</a>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <p>Localização Atual: {{Storage::disk('s3')->path($file->path)}} </p>
                    </div>
                    
                    <hr>

                    <div class="mb-3">
                        <label for="" class="form-label">Destino</label>
                        <select class="form-select form-select-lg" name="folder_id" id="">
                            @php use App\Models\Folder; $folders=Folder::all(); @endphp
                            @php
                              $myfolders=Folder::where('user_id','=',Auth::id())->get();
                            @endphp

                            @foreach($myfolders as $folder)
                                <option value="{{$folder->id}}"> {{$folder->name}} </option>
                            @endforeach

                        </select>
                    </div>

                    <button class="btn btn-primary">Mover</button>
                </form>

            </div>


        </div>

    </div>


@endsection
