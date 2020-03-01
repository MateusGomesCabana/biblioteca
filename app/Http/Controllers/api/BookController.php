<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\books;
use App\Models\authors;
use App\Models\lendings;
use DB;
use Validator;
use Auth;

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
        if (Auth::user()->role == 0) {
            $books = books::get();
            $authors = authors::get();
            $selected_cat = [];

            return view('book.index', compact('books', 'authors', 'selected_cat'));
        } else {
            return redirect()->route('home');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        if (Auth::user()->role == 0) {
            $authors = authors::get();
            return view('book.add', compact('authors'));
        } else {
            return redirect()->route('home');
        }
    }
    public function search(Request $request)
    {
        if (Auth::user()->role == 0) {
            $name = $request->input('name');
            $selected_cat = $request->input('category');
            $search = TRUE;
            $query = DB::table('books')
                ->select('books.id', 'books.title', 'books.description','books.image')
                ->join('books_authors', 'books.id', '=', 'books_authors.books_id')
                ->join('authors', 'books_authors.authors_id', '=', 'authors.id');

            if (!empty($name) && !empty($selected_cat)) {
                $query->where('books.title', 'like', '%' . $name . '%');
                $query->whereIn('authors.id', $selected_cat);
            } else if (!empty($name)) {
                $query->where('books.title', 'like', '%' . $name . '%');
            } else if (!empty($selected_cat)) {
                $query->whereIn('authors.id', $selected_cat);
            }
            $authors = authors::get();
            $books = $query->get();
            if (empty($selected_cat)) {
                $selected_cat = [];
            }
            
            return view('book.index', compact('books', 'authors', 'selected_cat', 'search'));
        } else {
            return redirect()->route('home');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role == 0) {
            $books = books::find($id);

            if (!empty($books)) {
                $authors = authors::get();
                $images = $books->image;
                $selected_cat = array();
                foreach ($books->authors as $author) {
                    $selected_cat[] = $author->pivot->authors_id;
                }
                return view('book.edit', compact('books', 'authors', 'selected_cat', 'images'));
            }

            return redirect()->route('book.index');
        } else {
            return redirect()->route('home');
        }

        //return view('book.edit');
    }


    public function save(Request $request)
    {

        if (Auth::user()->role == 0) {
            if (!empty($request->file('images'))) {
                $fileName = time() . '.' . $request->file('images')[0]->getClientOriginalExtension();
                $request->file('images')[0]->move($this->path, $fileName);
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:10|max:255',
                    'description' => 'required',
                ]);
                //!$validator->fails()
                if (!$validator->fails()) {
                    $images = $request->file('images');

                    $books = books::create([
                        'title' => $request->input('name'),
                        'image' => $fileName,
                        'description' => $request->input('description')
                    ]);

                    $books->authors()->sync($request->input('category'));


                    //deu certo
                    return redirect()->route('book.index');
                }
            }

            //retornar para mesma pagina
            return redirect()->route('book.add')->with('jsAlert', 'erro');
        } else {
            return redirect()->route('home');
        }
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
        if (Auth::user()->role == 0) {
            $images = $request->file('images');

            $authors = $request->input('category');

            $books = books::find($id);

            if (!empty($books)) {
                if (!empty($images)) {
                    $fileName = time() . '.' . $request->file('images')[0]->getClientOriginalExtension();
                    $request->file('images')[0]->move($this->path, $fileName);
                } else {
                    $fileName = $books->image;
                }

                if (!empty($authors)) {
                    $books->authors()->sync($authors);
                }
                $books->update([
                    'title' =>  $request->input('name'),
                    'image' => $fileName,
                    'description' =>  $request->input('description')
                ]);

                //se deu certo
                return redirect()->route('book.index');
            }
            //se der o errado

        } else {
            return redirect()->route('home');
        }
    }

    public function delete($id)
    {

        if (Auth::user()->role == 0) {
            $books = books::find($id);

            if (!empty($books)) {

                if (file_exists($this->path . '/' . $books->image)) {

                    unlink($this->path . '/' . $books->image);
                }

                $books->authors()->detach();
                $books->lendings()->detach();

                $result = $books->delete();
                return redirect()->route('book.index');
                //se der certo
            }
            //se der errado
            return redirect()->route('book.index');
        } else {
            return redirect()->route('home');
        }
    }
}
