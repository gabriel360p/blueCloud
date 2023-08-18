<?php



namespace App\Http\Controllers;

use App\Models\{File,Folder};
use Illuminate\Http\Request;
use App;
use Auth;
use Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('files.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $s3 = App::make('aws')->createClient('s3');

        // $s3->putObject(array(
        //     'Bucket'     => "bucket-blue-bloud-1",   
        //     'Key'        => 'enso.jpg',
        //     'SourceFile' => $request->file('file')->getRealPath(),
        // ));
        
        //FUNCIONOUUU!
        //procurando a pasta para salvar o arquivo, a pasta precisa ter sido "criada" anteriormente
        $folder=\DB::table('folders')->where('id','=',$request->folder_id)->get();

        foreach ($folder as $fol) {
            $folder_id=$fol->id;
            $folder_name=$fol->name;
        }
        $folder=Folder::find($folder_id);
        
        //salvando no drive e caso a pasta não tenha sido criada, ela vai ser criada agora
        //ele vai criar uma pasta para cada usuário, cada usuário terá a sua pasta "raíz" e dentro terá as outras subpastas
        $path = Storage::disk('s3')->putFile(Auth::user()->nickname."/".$folder_name, $request->file('file'));    

        //capturando o nome do arquivo via regex para poder salvar no banco o novo nome do arquivo.
        $string =Storage::disk('s3')->path($path);
        $padrao = '/'.$folder_name.'\/([^\/]+)/';
        preg_match($padrao, $string, $matches);
        $nameFile = $matches[1]; 
        
        //capturando o nome original do arquivo
        $extension = $request->file('file')->getClientOriginalExtension();
        
        File::create([
            'type'=>$extension,
            'path'=>$path,
            'original_name'=>$request->file('file')->getClientOriginalName(),
            'url'=>Storage::disk('s3')->url($path),
            'user_id'=>Auth::id(),
            'folder_id'=>$folder_id,
            'new_name'=>$nameFile,
        ]);

        //atualizando o status da pasta
        $folder->update([
            'create'=>1,
        ]);

        return back();
    }


    public function movePage (File $file)
    {
        return view('files.move',['file'=>$file]);
    }

    public function moveAction (File $file, Request $request)
    {
        //construindo uma string que indica o caminho para a nova pasta.
        $newfolder=Folder::find($request->folder_id);
        if($newfolder->create==false){
            echo "Esta pasta está vazia, portanto não existe no serviço em nuvem, antes dessa ação precisa-se existir algum outro arquivo.";
        }else{
            
            $newPath=Auth::user()->nickname."/".$newfolder->name."/".$file->new_name;
    
            //movendo na nuvem.
            Storage::disk('s3')->move($file->path, $newPath);
    
            $file->update([
                'path'=>$newPath,
                'url' =>Storage::disk('s3')->url($newPath),
                'folder_id'=>$newfolder->id,
            ]);
            
            return back();
        }
    }

    public function download (File $file)
    {
        return Storage::disk('s3')->download($file->path);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //funcionando

        //apagando da nuvem
        Storage::disk('s3')->delete($file->path);

        //apagando do banco
        $file->delete();
        
        return back();
    }
}
