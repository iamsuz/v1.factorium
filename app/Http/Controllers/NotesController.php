<?php

namespace App\Http\Controllers;

use App\Note;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteRequest $request)
    {
        $request['admin_id']= Auth::user()->id;
        $request['from_admin']= Auth::user()->first_name;
        $user = User::findOrFail($request['user_id']);
        $note = $user->notes->last();
        $note_content = null;
        if($note) {
            $note_content = $note->content;
        }
        if($request['content'] == $note_content) {
            return response()->json();
        }
        $note = Note::create($request->all());
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
