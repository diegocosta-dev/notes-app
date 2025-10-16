<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
		$id = session('user.id');
		$notes = User::find($id)
                 ->notes()
                 ->whereNull('deleted_at')
                 ->get()
                 ->toArray();

		return view('home', ['notes' => $notes]);
    }

    public function addNote()
    {
        return view('add_note');
    }

    public function noteSubmit(Request $request)
    {
        $request->validate(
            [
                'text_title' => 'required|min:3|max:255',
                'text_note' => 'required|min:3|max:2056'
            ],
            [
                'text_title.required' => 'The Title is Required.',
                'text_title.min' =>  'The Title must be at least :min characters.',
                'text_title.max' =>  'The Title must not exceed :max characters.',
                'text_note.required' => 'The Note is Required.',
                'text_note.min' =>  'The Note must be at least :min characters.',
                'text_note.max' =>  'The Note must not exceed :max characters.',
            ]
        );

        $userId = session('user.id');

        $note = new Note();
        $note->user_id = $userId;

        $note->title = $request->text_title;
        $note->text = $request->text_note;

        $note->save();

        return redirect()->route('home')->with('success', 'Note successfully saved.');
    }
    
    public function editNote($id)
    {
        $id = Operations::decriptHash($id);

        if ($id == null) 
        {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        $request->validate(
            [
                'text_title' => 'required|min:3|max:255',
                'text_note' => 'required|min:3|max:2056'
            ],
            [
                'text_title.required' => 'The Title is Required.',
                'text_title.min' =>  'The Title must be at least :min characters.',
                'text_title.max' =>  'The Title must not exceed :max characters.',
                'text_note.required' => 'The Note is Required.',
                'text_note.min' =>  'The Note must be at least :min characters.',
                'text_note.max' =>  'The Note must not exceed :max characters.',
            ]
        );

        if ($request->note_id == null)
        {
            return redirect()->route('home');
        }

        $id = Operations::decriptHash($request->note_id);

        if ($id == null) 
        {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home')->with('success','Note update successfully.');
    }

    public function deleteNote($id)
    {
        $id = Operations::decriptHash($id);

        if ($id == null) 
        {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('delete_note', ['note' => $note]);
    }

    public function deleteNoteConfirm($id)
    {
        $id = Operations::decriptHash($id);

        if ($id == null) 
        {
            return redirect()->route('home');
        }

        $note = Note::find($id);
        // $note->deleted_at = Carbon::now()->toDateTimeString();
        // $note->save();
        
        $note->delete();

        return redirect()->route('home')->with('success','Note was removed successfully');
    }

}
