@extends('layouts.master')


<style>
	.personal-container{
		display: grid;
		grid-template-columns: repeat(3, auto);
		grid-template-rows: auto auto;
	}
	img{
		height: auto;
		width: auto;
	}
</style>

@section('body-content')
	<div class="row">
		<div class="col">
			<h1>BlueCloud de {{Auth::user()->nickname}}</h1>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<div class="personal-container">
				@php use App\Models\{Folder,File};@endphp
				@foreach ($files as $file)

				@if ($file->type=='pdf'||$file->type=='word')
					<div class="card" style="width: 18rem;">
						<div class="card-body">
						<a href="{{Storage::disk('s3')->url($file->path)}}"> 
						<h5 class="card-title">ARQUIVO {{$file->type}} </h5>
						<p class="card-text"><small class="text-body-secondary"> 
							@php 
								$date = new DateTime();
								$date->format('U = Y-m-d H:i:s') . "\n";
								
								$date->setTimestamp(Storage::disk('s3')->lastModified($file->path));
								echo "Atualizando em ". $date->format('Y-m-d H:i:s') . "\n";

							@endphp
						</small></p>
						</a>
						</div>
						<div class="card-footer text-center">
						<div class="btn-group" role="group" aria-label="Button group">
							<a   href="{{url('/files/destroy',$file->id)}}" class="btn btn-primary">Deletar</a>
							<a   href="{{url('/files/download',$file->id)}}" class="btn btn-primary">Baixar</a>
							<a   href="{{url('/files/move',$file->id)}}" class="btn btn-primary">Mover</a>
						</div>
					</div>
				  	</div>
				@else

				<div class="card">
					<a href="{{Storage::disk('s3')->url($file->path)}}">
						<img src="{{$file->url}}" class="card-img">
					</a>
					<div class="card-body">
						<p class="card-text"> 
							@php								
								$folder = Folder::where('id','=',$file->folder_id)->get();

								foreach ($folder as $folderInfor) {
									echo "Pasta atual: ".$folderInfor->name;
									echo "<hr>";
								}
							@endphp
							Caminho Interno: {{Storage::disk('s3')->path($file->path)}}
						</p>
					</div>

					<div class="card-footer text-center">
						<div class="btn-group" role="group" aria-label="Button group">
							<a   href="{{url('/files/destroy',$file->id)}}" class="btn btn-primary">Deletar</a>
							<a   href="{{url('/files/download',$file->id)}}" class="btn btn-primary">Baixar</a>
							<a   href="{{url('/files/move',$file->id)}}" class="btn btn-primary">Mover</a>
						</div>
					</div>

				</div>
				@endif

				
				@endforeach
			</div>

		</div>
	</div>
	
	

@endsection



