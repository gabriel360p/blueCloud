@extends('layouts.master')



@section('body-content')

	<h1>Upload de Arquivo</h1>

    <div class="container">

        <div class="row">

            <div class="col">

                <form action="/files/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="" class="form-label">Escolher Arquivo</label>
                      <input type="file" class="form-control" name="file" id="" placeholder="" aria-describedby="fileHelpId">
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="" class="form-label">Pasta</label>
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

                    <button class="btn btn-primary">Enviar</button>
                </form>

            </div>

        </div>

    </div>


@endsection
