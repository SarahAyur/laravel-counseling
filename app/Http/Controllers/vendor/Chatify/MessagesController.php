<?php

namespace App\Http\Controllers\Vendor\Chatify;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Chatify\Facades\ChatifyMessenger as Chatify;
use App\Models\ChMessage as Message;
use App\Models\ChFavorite as Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as Req;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessagesController extends Controller
{
    protected $perPage = 30;

    public function index($id = null)
    {
        $routeName = Req::route()->getName();
        $type = in_array($routeName, ['user','group']) ? $routeName : 'user';
        
        if (auth()->user()->isMahasiswa()) {
            // Remove search for mahasiswa
            return view('Chatify::pages.app', [
                'id' => $id ?? 0,
                'type' => $type ?? 'user',
                'messengerColor' => Auth::user()->messenger_color ?? $this->messengerFallbackColor,
                'dark_mode' => Auth::user()->dark_mode < 1 ? 'light' : 'dark',
                'hideSearch' => true
            ]);
        }
        
        return view('Chatify::pages.app', [
            'id' => $id ?? 0,
            'type' => $type ?? 'user',
            'messengerColor' => Auth::user()->messenger_color ?? $this->messengerFallbackColor,
            'dark_mode' => Auth::user()->dark_mode < 1 ? 'light' : 'dark',
        ]);
    }

    public function search(Request $request)
    {
        if (auth()->user()->isMahasiswa()) {
            return Response::json([
                'records' => []
            ]);
        }
        
        $input = trim(filter_var($request['input']));
        $records = User::where('id','!=',Auth::user()->id)
                      ->where('name', 'LIKE', "%{$input}%")
                      ->paginate($this->perPage);

        foreach ($records->items() as $record) {
            $record->avatar = Chatify::getUserWithAvatar($record)->avatar;
        }

        return Response::json([
            'records' => $records->items(),
            'total' => $records->total(),
            'last_page' => $records->lastPage()
        ]);
    }

    // ...existing Chatify methods...
}