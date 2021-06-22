<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpline;
use App\ResourceType;
use App\ContentType;
use App\Status;
use App\ReferenceBy;
use App\ReferenceTo;
use App\Fakenews;
use App\FakenewsType;
use App\FakenewsPictures;
use App\FakenewsPictureReff;
use App\FakenewsSourceType;
use App\User;
// use App\ActionTaken;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = Status::all();
        $users = User::all();
        $fakenewstype = FakenewsType::all();
        $fakenewssourcetype = FakenewsSourceType::all();
        $resource_types = ResourceType::all();
        $content_types  = ContentType::all();
        $content_types  = ContentType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();

        $request->flash();


        if ($request->filterStatus && $request->filterStatus!=='*') {
            $statusSelected = $request->filterStatus;
        } else {
            $statusSelected = "%";
        }
        
        $user = auth()->user();

        // admin & manager get all reports.
        if ($user->hasRole("admin") || $user->hasRole("manager")) {
            $helpline = Helpline::where(function ($query) use ($statusSelected){
                    $query->where('status', 'LIKE' ,$statusSelected);
                })->get();
            $fakenews = Fakenews::where(function ($query) use ($statusSelected){
                    $query->where('status', 'LIKE' ,$statusSelected);
                })->get();
        }else {
            $helpline = Helpline::where(function ($query ) use ($statusSelected){
                    $query->where('status', 'LIKE' ,$statusSelected)
                          ->where('status', '!=', 'Closed') 
                          ->where('user_assigned', Auth::id()) 
                          ->orwhere('forwarded', "true") 
                          ->orwhere('user_opened', NULL);
                })->orwhere(function($query)  use ($statusSelected) {
                    $query->where('status', 'LIKE' , $statusSelected)
                          ->where('status', '!=', 'Closed')
                          ->where('user_opened', Auth::id())
                          ->where('user_assigned', NULL);
                })->get();
                
            $fakenews = Fakenews::where(function ($query) use ($statusSelected) {
                    $query->where('status', 'LIKE' , $statusSelected)
                          ->where('user_assigned', Auth::id())
                          ->orwhere('user_opened', NULL);
                })->where(function($query) {
                    $query->where('user_opened', Auth::id())
                          ->where('user_assigned', NULL);
                })->get();
        }


        return view('home')->with([
                    'helpline'=> $helpline,
                    'fakenews'=> $fakenews,
                    'fakenews_type' => $fakenewstype,
                    'fakenews_source_type' => $fakenewssourcetype,
                    'resource_types' => $resource_types,
                    'content_types' => $content_types,
                    'references_by' => $references_by,
                    'references_to' => $references_to,
                    'status' => $status,
                    'users' => $users
                ]);
    }
}
