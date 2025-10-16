<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
		$id = session('user.id');
		$notes = User::find($id)->notes()->get()->toArray();

		return view('home', ['notes' => $notes]);
    }

    public function addNote()
    {
		//
    }
    
    public function editNote($id)
    {
		$id = Operations::decriptHash($id);
		echo $id;
    }

    public function deletNote($id)
    {
		$id = Operations::decriptHash($id);
		echo $id;
    }

}
