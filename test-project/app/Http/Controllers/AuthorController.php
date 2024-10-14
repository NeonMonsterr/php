<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    public function show($id)
    {
        $author = Author::findOrFail($id);
        return view('authors.show', compact('author'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request) // Added Request type hint
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'book_count' => 'required|integer|min:0'
        ]);
        
        Author::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'book_count'=>$request->input('book_count')
        ]);
        
        return redirect()->route('authors.index');
    }
    public function destory($id){
    // Author::find($id)->restore();
    Author::where('id',$id)->onlyTrashed()->restore();
    return 'returned successfully!';
    }
}
