<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;



class PostController extends Controller
{
    public function actuallyUpdate(Post $post, Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'Post successfully updated.');
    }

    public function showEditForm(Post $post) {
        return view('edit-post', ['post' => $post]);
    }

    public function delete(Post $post) {
        $post->delete();
        return redirect('/profile/' . auth()->user()->username)->with('success', 'Post successfully deleted.');
    }

    public function viewSinglePost(Post $post) {
        $post['body'] = strip_tags(Str::markdown($post->body), '<p><ul><ol><li><strong><em><h3><br>');
        return view('single-post', ['post' => $post]);
    }

    public function storeNewPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created.');
    }

    public function showCreateForm() {
        return view('create-post');
    }

    public function makeRequest(Request $request) 
    {
        $collections = collect($request);
        $eventIds = $collections->get('eventId');
        $mainOrBombs = $collections->get('mainOrBomb');

        if (!empty($eventIds)) 
        {
            foreach($eventIds as $eventId)
            {
                
                DB::table('posts')
                ->where('eventId', '=', $eventId)
                ->update(array(
                    'isApproved' => 1
                ));                
            }
        }

        if (!empty($mainOrBombs)) 
        {
            foreach($mainOrBombs as $mainOrBomb)
            {
                DB::table('posts')
                ->where('eventId', $mainOrBomb)
                ->update(array(
                    'isBomb' => 1
                ));
            }
        }
        return back()->with('success', 'Regear has been requested');
    }


    public function checkRequest(Request $request) 
    {
        $user = auth()->user();

        //$regearRequests = DB::table('posts')
        //    ->leftJoin('users', 'posts.user_id', '=', 'users.id')
        //    ->where('isApproved', '>=', 1)
        //    ->where('posts.user_id', '=', auth()->user()->id)
        //    ->orderBy('timeKilled', 'desc')
        //    ->select('posts.*')
        //    ->paginate(15);

        $regearRequests = DB::table('posts')
            ->where('isApproved', '>=', 1)
            ->where('user_id', '=', auth()->user()->id)
            ->orderBy('timeKilled', 'desc')
            ->select('posts.*')
            ->paginate(15);

        return view('check-request', ['avatar' => $user->avatar, 'username' => $user->username, 'posts' => $regearRequests]);
    }


    public function cancelRequest(Request $request) 
    {

        $eventId = Arr::get($request->toArray(),'getRid.0');

        Post::where('eventId', $eventId)->update(['isApproved'=>'0', 'isBomb'=>'0']);

        return back();
    }

    public function changeTag(Request $request)
    {
        $collections = collect($request);
       
        $bombValue = Arr::get($request->toArray(),'bombValue.0');

        if($bombValue == 0)
        {
            //change to bomb squad
            Post::where('eventId', $collections->get('changeTag'))->update(['isBomb'=>'1']);
        }
        elseif($bombValue == 1)
        {
            //change to main zerg
            Post::where('eventId', $collections->get('changeTag'))->update(['isBomb'=>'0']);
        }



        return back()->with('success', 'Changed tag type');
    }



}


