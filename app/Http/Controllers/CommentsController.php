<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Project;
use App\CommentVote;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mailers\AppMailer;
use App\User;

class CommentsController extends Controller
{
    /**
     * constructor for UsersController
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($projects)
    {
        $project = Project::findOrFail($projects);
        $comments = $project->comments();
        dd($comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($projects)
    {
        $project = Project::findOrFail($projects);
        return view('projects.comments.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $projects, AppMailer $mailer)
    {
        $project = Project::findOrFail($projects);

        $request['project_id']= $projects;
        $request['user_id']= Auth::id();

        $comment = Comment::create($request->all());
        $comment->project_site = url();
        $comment->save();
        $user = User::find($comment->user_id);

        $mailer->sendUserFeedbackEmailToAdmins($project, $user, $comment);

        return redirect()->back();

        /*return redirect()->to('/projects/'.$projects.'#comments-form');*/
    }

    public function storeVote(Request $request, $projects, $comments)
    {
        $project = Project::findOrFail($projects);
        $comment = Comment::findOrFail($comments);

        $request['project_id']= $projects;
        $request['comment_id']= $comments;
        $request['user_id']= Auth::id();
        $comment = CommentVote::where('project_id', $projects)->where('user_id', Auth::id())->where('comment_id', $comments)->first();
        if($comment) {
            $comment->update($request->all());
        } else {
            CommentVote::create($request->all());
        }
        return redirect()->to('/projects/'.$projects.'#comments-form');
    }

    public function storeReply(Request $request, $projects, $comments)
    {
        $project = Project::findOrFail($projects);
        $comment = Comment::findOrFail($comments);

        $request['project_id']= $projects;
        $request['reply_id']= $comments;
        $request['user_id']= Auth::id();
        $comment = Comment::create($request->all());
        return redirect()->to('/projects/'.$projects.'#comments-form');
    }

    public function deleteComment($projects, $comments)
    {
        $project = Project::findOrFail($projects);
        $comment = Comment::findOrFail($comments);
        $comment->delete();
        return redirect()->to('/projects/'.$projects.'#comments-form')->withMessage('<p class="alert alert-success text-center">Comment Deleted Successfully.</p>');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($projects, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($projects, $id)
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
    public function update(Request $request, $projects, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($projects, $id)
    {
        //
    }
}
