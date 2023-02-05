<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class RegentController extends Controller
{
    private $regent;
    public function __construct(UserInterface $userInterface)
    {
        parent::__construct();
        // $this->middleware('jwtauth')->except([]);
        // $this->middleware('jwtnoauth')->only([]);
        $this->regent = $userInterface;
    }
    
    public function homePage()
    {
        return view('regent.home');
    }

    public function summary()
    {
        return $this->regent->summary();
    }
    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        //
    }
    
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        //
    }
    
    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
