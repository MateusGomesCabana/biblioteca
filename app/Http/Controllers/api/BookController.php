<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\books;
use App\Models\authors;
use App\Models\lendings;
use DB;
use Validator;
class BookController extends Controller
{
    private $path = 'images/product';

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('book.add');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('book.edit');
    }
    public function save(Request $request)
    {

        if (!empty($request->file('image')) && $request->file('image')->isValid()) {
            $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($this->path, $fileName);
        }


        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|min:10|max:255',
        //     'description' => 'required',
        // ]);
            //!$validator->fails()
        if(true){
            $images = $request->file('images');
            $books = books::create([
                'title' => $request->input('title'), 
                'image' => $fileName,
                'description' => $request->input('description')
            ]);
               
            $books->authors()->sync($request->input('category'));
            //deu certo
        }
        //retornar para mesma pagina

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
        $images = $request->file('images');
        $authors = $request->input('category');

        $books = books::find($id);

        if(!empty($books)){
            if(!empty($images)){
                $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move($this->path, $fileName);
            }

            if(!empty($authors)){
                $books->authors()->sync($authors);
            }
            $books->update([
                'title' =>  $request->input('title'),
                'image' => $fileName,
                'description' =>  $request->input('description')
            ]);
            //se deu certo
        }
        //se der o errado
        return redirect()->route('product.index');
    }

    public function delete($id)
    {
        $books = books::find($id);

        if(!empty($books)){

            if(file_exists($this->path . '/' . $books->image)){
                unlink($this->path . '/' . $books->image);
            }
           
            $books->authors()->detach();
            $books->lendings()->detach();
           
            $result = $books->delete();
            //se der certo
        }
        //se der errado
        return redirect()->route('product.index');
    }

    
}
