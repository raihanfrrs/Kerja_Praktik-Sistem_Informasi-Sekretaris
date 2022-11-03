<?php

namespace App\Http\Controllers;

class LayoutController extends Controller
{
    public function index(){
        return view('welcome');
    }
}
