<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\books;
use App\Models\authors;
use App\Models\lendings;
use DB;
use Auth;

class LoanController extends Controller
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
        $user = Auth::user();
        $books = books::get();
        $authors = authors::get();
        $selected_cat = [];

        return view('loan.index', compact('books', 'authors', 'selected_cat'));
    }
    /**
     * Para alugar
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $user = Auth::user();
        $books = books::get();
        $authors = authors::get();
        $selected_cat = [];
        return view('loan.add', compact('books', 'authors', 'selected_cat'));
    }
    public function search(Request $request)
    {
       
        $name = $request->input('name');
        $selected_cat= $request->input('category');
        $search= TRUE;
        $query = DB::table('books')
                    ->select('books.id','books.title','books.description','books.image')
                    ->join('books_authors','books.id','=','books_authors.books_id')
                    ->join('authors','books_authors.authors_id','=','authors.id');
                    
        if (!empty($name) && !empty($selected_cat)) {
            $query->where('books.title','like','%'.$name.'%');
            $query->whereIn('authors.id',$selected_cat);
        }else if(!empty($name)){
            $query->where('books.title','like','%'.$name.'%');
        }else if(!empty($selected_cat)){
            $query->whereIn('authors.id',$selected_cat);
        }
        $authors = authors::get();
        $books= $query->get();
        if(empty($selected_cat)){
            $selected_cat = [];
        }
        return view('book.index',compact('books','authors','selected_cat','search'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        $queryString = "SELECT * FROM lendings inner join books_lendings on  id = lendings_id
                        inner join books on  books_lendings.books_id = books. id
                        WHERE date_finish is null and user_id =" . $user->id;

        $query = DB::select($queryString);
        $books = new books;
        $lendings = new lendings();
        $booksColection = array();
        $lendingsColection = array();
        if (!empty($query)) {
            foreach ($query as $item) {
                $books->title = $item->title;
                $books->description = $item->description;
                $books->image = $item->image;
                $booksColection[] =  $books;
                $lendings->date_start = $item->date_start;
                $lendings->date_end = $item->date_end;
                $lendingsColection[] = $lendings;
            }
        }
    
        return view('loan.edit', compact('query'));
    }
    public function save($id)
    {
        $books = books::find($id);
        if (!empty($books)) {
            $user = Auth::user();
            $dateHj = date("Y/m/d");
            $dateHj = date("Y-m-d", strtotime($dateHj . "+7 days"));
            $lendings = new lendings();
            $lendings->date_start = date("Y/m/d");
            $lendings->date_end = $dateHj;
            $lendings->date_finish = null;
            $lendings->user_id = $user->id;
            $lendings->save();
            $lendings->books()->sync($books);
            return redirect()->route('loan.edit');
        }
        //se der errado
        return redirect()->route('loan.edit');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $message = "teste";
       
        $user = Auth::user();
        $lendings = DB::table('lendings')->where('user_id', '=', $user->id)->where('date_finish', '=', null)->get();
        $flag = false;
       
        foreach ($lendings as $lending) {
            if ($lending->date_end > date("Y/m/d")) {
                $flag = true;
                break;
            }
        }
        if (!$flag) {
            $lendings = lendings::find($id);
            if (!empty($lendings)) {
                $lendings->update([
                    'date_end' => date("Y-m-d", strtotime(date("Y/m/d") . "+7 days"))
                ]);
                return redirect()->route('loan.edit')->with('jsAlert', 'updated succesfully');
            } 
        }else{
            //so vai ser possivel devolver
            return redirect()->route('loan.edit')->with('jsdAlert', 'updated succesfully');

        }
        return redirect()->route('book.edit');
    }

    public function delete($id)
    {
        $lendings = lendings::find($id);
        if (!empty($lendings)) {
            $lendings->update([
                'date_finish' => date("Y-m-d")
            ]);
            return redirect()->route('loan.edit');
        }
        return redirect()->route('loan.edit');
    }
}
