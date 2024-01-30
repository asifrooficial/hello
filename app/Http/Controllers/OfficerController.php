<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class OfficerController extends Controller
{
    public function viewRequests()
    {
        $officersGuild = auth()->user()->guildId;

        $requests = DB::table('posts')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->where('isApproved', '>=', 1)
            ->where('users.guildId', '=', $officersGuild)
            ->orderBy('isApproved', 'asc')
            ->orderBy('username', 'asc')
            ->orderBy('timeKilled', 'asc')
            ->select('posts.*', 'users.username')
            ->paginate(15);

        //return view('approverequest', ['requests' => $requests]);
        return view('approverequest', ['requests' => $requests]);
    }

    public function processRequests(Request $request)
    {
        $incomingFields = $request->validate([
            'requests' => 'required'
        ]);

        $incomingFields = $incomingFields['requests'];

        //$incomingFields = explode(',', $incomingFields);
        foreach($incomingFields as $incomingField)
        {
            $exploded = explode(',', $incomingField);
            $requestId = $exploded['0'];
            $isApproved = $exploded['1'];
            
            if ($isApproved == 'approved') 
            {
                DB::table('posts')
                    ->where('id', $requestId)
                    ->update(['isApproved' => 3]);
            } 
            else 
            {
                DB::table('posts')
                    ->where('id', $requestId)
                    ->update(['isApproved' => 2]);
            }
                   
        }

        return $this->viewRequests();
    }

    public function searchRequest()
    {
        return view('approverrequest-search');
    }
}