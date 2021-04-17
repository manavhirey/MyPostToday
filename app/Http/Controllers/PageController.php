<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        $title = 'Welcome to MyPostToday!';
        return view ('pages.index') -> with('title', $title);
    }

    public function about(){
        return view ('pages.about');
    }

    public function services(){
        $data = array(
            'title' => 'Services',
            'services' => ['Blog Posts', ' Custom Websites', 'App Devlopment']
        );
        return view('pages.services')->with($data);
    }
}
