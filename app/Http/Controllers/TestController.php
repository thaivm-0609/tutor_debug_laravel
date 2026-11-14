<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() 
    {
        //$tests = Test::all(); //nếu view lấy dữ liệu từ các relation subject, major => duplicate query
        $tests = Test::with(['subject.major'])->get();

        return view('tests', compact('tests'));
    }
}
