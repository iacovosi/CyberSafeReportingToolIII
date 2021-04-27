<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpline;
use App\ResourceType;
use App\ContentType;
use App\Status;
use App\ReferenceBy;
use App\ReferenceTo;
use App\User;
// use App\ActionTaken;
use Illuminate\Support\Facades\Crypt;
use Auth;

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
        $resource_types = ResourceType::all();
        $content_types  = ContentType::all();
        $content_types  = ContentType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();

        $request->flash();

        // APPLY FILTERING //
        if ($request->filterStatus) {
            $statusSelected = $request->filterStatus;

            // ...set filters but dont get resuts yet, due to pagination and export conflict
            $user = auth()->user();


            // admin & manager get all reports.
            if ($user->hasRole("admin") || $user->hasRole("manager")) {
                $helpline = Helpline::ofStatus($statusSelected)->get();
            }
            else {
                if ($statusSelected!="*") {
                    $helpline = Helpline::where(function ($query) use ($statusSelected) {
                        $query->select('*')
                                ->where('status', '=', $statusSelected)
                                ->where('user_assigned', Auth::id())
                                ->orwhere('user_assigned', NULL)
                                ->orwhere('user_opened', Auth::id())
                                ->orwhere('user_opened', NULL)
                                ->orwhere('forwarded', "true");
                    })->get();
                }
                else {
                    $helpline = Helpline::where(function ($query) {
                        $query->select('*')
                              ->where('user_assigned', Auth::id())
                              ->orwhere('user_assigned', NULL)
                              ->orwhere('user_opened', Auth::id())
                              ->orwhere('user_opened', NULL)
                              ->orwhere('forwarded', "true");
                    })->get();
                }
            }
        } else {

            $user = auth()->user();
            
            // admin & manager can view everything.
            if ($user->hasRole("admin") || $user->hasRole("manager")) {
                $helpline = Helpline::ofStatus("*")->get();
            }
            else {
                $helpline = Helpline::where(function ($query) {
                    $query->select('*')
                          ->where('user_assigned', Auth::id())
                          ->orwhere('user_assigned', NULL)
                          ->orwhere('user_opened', Auth::id())
                          ->orwhere('user_opened', NULL)
                          ->orwhere('forwarded', "true");
                })->get();

            }
        }

        return view('home')->with([
            'helpline'=> $helpline,
            'resource_types' => $resource_types,
            'content_types' => $content_types,
            'references_by' => $references_by,
            'references_to' => $references_to,
            'status' => $status,
            'users' => $users
        ]);
    }
}
