<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function storeAvatar(Request $request) 
    {
        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);

        $user = auth()->user();

        $filename = $user->id . '-' . uniqid() . '.jpg';

        $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/' . $filename, $imgData);

        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar != "/fallback-avatar.jpg") {
            Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
        }

        return back()->with('success', 'Avatar saved');
    }

    public function showAvatarForm() 
    {
        return view('avatar-form');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function showCorrectHomepage() 
    {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function login(Request $request) 
    {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return redirect('/')->with('failure', 'User not found or invalid credentials');
        }
    }

    public function register(Request $request) 
    {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:4', 'max:20', Rule::unique('users', 'username')],
            'password' => ['required', 'min:4', 'confirmed']
        ]);

        //Encrypt Password in DB
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        //Get albion details from API
        $apiQuery = 'https://gameinfo-sgp.albiononline.com/api/gameinfo/search?q='.$incomingFields['username'];
        $playerInfo = Http::get($apiQuery);

        $playerInfoArray = json_decode($playerInfo, true);
        
        //$name = Arr::get($playerInfoArray,'players.0.Name');
        $playerID = Arr::get($playerInfoArray,'players.0.Id');
        $guildID = Arr::get($playerInfoArray,'players.0.GuildId');
        $guildName = Arr::get($playerInfoArray,'players.0.GuildName');
        $allianceID = Arr::get($playerInfoArray,'players.0.AllianceId');
        $allianceName = Arr::get($playerInfoArray,'players.0.AllianceName');

        //Add it back to the array
        $collection = collect([
            'username' => $incomingFields['username'], 
            'password' => $incomingFields['password'],
            'playerId' => $playerID, 
            'guildId' => $guildID, 
            'guildName' => $guildName, 
            'allianceId' => $allianceID, 
            'allianceName' => $allianceName,
        ]);

        $collection = $collection->toArray();

        //record id in DB
        $user = User::create($collection);

        return redirect('/')->with('success', 'Your account is now registered');
        
    }

    //Show Regear Requests
    public function profile(User $user) 
    {
        $user = auth()->user();
        $apiQuery = 'https://gameinfo-sgp.albiononline.com/api/gameinfo/players/'.$user->playerId.'/deaths';

        //STILL NEED TO FIND A WAY TO CACHE THIS
        $playerInfo = Http::get($apiQuery);

        //Get Player details from albion East API
        $playerInfoArray = json_decode($playerInfo, true);
        
        //loop thru the array to get all 10 values from json query
        foreach($playerInfoArray as $playerInfo)
        {   
            $eventId = Arr::get($playerInfo, 'EventId');
            $mainHand = Arr::get($playerInfo, 'Victim.Equipment.MainHand.Type');
            $offHand = Arr::get($playerInfo, 'Victim.Equipment.OffHand.Type');
            $head = Arr::get($playerInfo, 'Victim.Equipment.Head.Type');
            $armor = Arr::get($playerInfo, 'Victim.Equipment.Armor.Type');
            $shoes = Arr::get($playerInfo, 'Victim.Equipment.Shoes.Type');
            $cape = Arr::get($playerInfo, 'Victim.Equipment.Cape.Type');
            $mount = Arr::get($playerInfo, 'Victim.Equipment.Mount.Type');
            $killer = Arr::get($playerInfo, 'Killer.Name');
            $killerGuild = Arr::get($playerInfo, 'Killer.GuildName');
            $killerAlliance = Arr::get($playerInfo, 'Killer.AllianceName');
            $timeKilled = Arr::get($playerInfo, 'TimeStamp');
            $bag = Arr::get($playerInfo, 'Victim.Equipment.Bag.Type');
            //$potion = Arr::get($playerInfo, 'Victim.Equipment.Potion.Type');
            //$food = Arr::get($playerInfo, 'Victim.Equipment.Food.Type');
            
            Post::updateOrCreate([
                'user_id' => $user->id,
                'eventId' => $eventId,
                'mainHand' => $mainHand, 
                'offHand' => $offHand,
                'head' => $head, 
                'armor' => $armor, 
                'shoes' => $shoes, 
                'cape' => $cape, 
                'mount' => $mount,
                'bag' => $bag,
                'killer' => $killer, 
                'killerGuild' => $killerGuild, 
                'killerAlliance' => $killerAlliance,
                'timeKilled' => $timeKilled
            ]); 
        }

        return view('profile-posts', ['avatar' => $user->avatar, 'username' => $user->username, 'posts' => $user->posts()->latest()->get()]);  
        
    }
 



}
