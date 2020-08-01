<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function index(){
        $title = 'Welcome To Laravel!';
        //return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    public function about()
    {
         $title = 'About Us';
        return view('pages.about')->with('title', $title);
    }

}