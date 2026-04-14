<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        // $data = new Library();
        // echo $data->test();

        // $library = Library::all();
        $library = Library::get();

        return view('library', ['library' => $library]);
    }
    public function show()
    {
        // $library = Library::where('price', '1440')->get(); -> price equals value
        // $library = Library::where('price','<=', '1440')->get(); -> price smaller than or equals value
        $library = Library::whereBetween('price', [100, 1300])->get(); //-> price between two values
        return $library;
    }
    public function store()
    {
        $library = Library::insert([
            'title' => 'Bright Fields',
            'author' => 'kale',
            'price' => '2003'
        ]);
        if ($library) {
            echo 'data inserted';
        } else {
            die('data not inserted');
        }
        return $library;
    }
    public function update()
    {
        $library = Library::where('id', 2)->update(['price'=> 3940]);
        if ($library) {
            echo 'data updated';
        } else {
            die('data not updated');
        }
        return $library;
    }
    public function destroy()
    {
        $deleted = Library::where('id', 5)->delete();
        if ($deleted) {
            echo 'data deleted';
        } else {
            die('data not deleted');
        };
    }
}
