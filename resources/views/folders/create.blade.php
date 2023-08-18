@extends('layouts.master')



@section('body-content')

	<h1>Nova Pasta</h1>

    <div class="container">

        <div class="row">

            <div class="col">

                <form action="/folders/store" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nome da pasta</label>
                        <input type="text" class="form-control" name="name" required id="" aria-describedby="helpId" placeholder="">
                        
                        <button class="btn btn-primary mt-2">Criar</button>
                    </div>
                </form>

            </div>

        </div>

        <hr>

        <div class="row">
            <h4>Pastas Encontradas</h4>
            @foreach ($folders as $folder)
            
                <li>{{$folder->name}}</li>    

            @endforeach

        </div>

    </div>


@endsection
