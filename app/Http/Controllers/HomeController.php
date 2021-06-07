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
        //$fakenews = Fakenews::all();
        $fakenewstype = FakenewsType::all();
        $fakenewssourcetype = FakenewsSourceType::all();
        $resource_types = ResourceType::all();
        $content_types  = ContentType::all();
        $content_types  = ContentType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();

        $request->flash();
        //dd($request);

        // APPLY FILTERING //
        if ($request->filterStatus) {
            $statusSelected = $request->filterStatus;

            // ...set filters but dont get resuts yet, due to pagination and export conflict
            $user = auth()->user();

            // admin & manager get all reports.
            if ($user->hasRole("admin") || $user->hasRole("manager")) {
                $helpline = Helpline::ofStatus($statusSelected)->get();
                $fakenews = Fakenews::ofStatus($statusSelected)->get();
            }else {
                if ($statusSelected!="*") {
                    $helpline = Helpline::where(function ($query) use ($statusSelected) {
                        $query->select('*')
                                ->where('status', '=', $statusSelected)
                                ->where('user_assigned', Auth::id())
                                ->orwhere('user_assigned', NULL)
                                ->orwhere('user_opened', Auth::id())
                                ->orwhere('user_opened', NULL)
                                ->orwhere('forwarded', "true");
                        })->where(function($query) {
                             $query->where('user_opened', Auth::id())
                                ->orwhere('user_opened',NULL)
                                ->orwhere('forwarded', "true");
                        })->get();

                    $fakenews = Fakenews::where('status', '=', $statusSelected)
                        ->where(function ($query) {
                            $query->where('user_assigned', Auth::id())
                                ->orwhere('user_assigned', NULL);
                        })->where(function($query) {
                             $query->where('user_opened', Auth::id())
                                ->orwhere('user_opened',NULL);
                        })->get();
                }else {
                    $helpline = Helpline::ofStatus("*")->where(function ($query) {
                            $query->where('user_assigned', Auth::id())
                                ->orwhere('user_assigned', NULL)
                                ->orwhere('forwarded', "true");
                        })->where(function($query) {
                            $query->where('user_opened', Auth::id())
                                ->orwhere('user_opened', NULL)
                                ->orwhere('forwarded', "true");
                        })->get();
                    $fakenews = Fakenews::ofStatus("*")->where(function ($query) {
                            $query->where('user_assigned', Auth::id())
                                ->orwhere('user_assigned', NULL);
                        })->where(function($query) {
                            $query->where('user_opened', Auth::id())
                                ->orwhere('user_opened', NULL);
                        })->get();
                }
            }
        } else {

            $user = auth()->user();
            
            // admin & manager can view everything.
            if ($user->hasRole("admin") || $user->hasRole("manager")) {
                $helpline = Helpline::ofStatus("*")->get();
                $fakenews = Fakenews::ofStatus("*")->get();
            }
            else {
                $helpline = Helpline::where('status','!=','Closed')
                    ->where(function ($query) {
                    $query->where('user_assigned',Auth::id())
                        ->orwhere('user_assigned',NULL)
                        ->orwhere('forwarded', "true");
                        })->where(function($query) {
                    $query->where('user_opened',Auth::id())
                        ->orwhere('user_opened',NULL)
                        ->orwhere('forwarded', "true");
                    })->get();
                $fakenews = Fakenews::where('status','!=','Closed')
                    ->where(function ($query) {
                    $query->where('user_assigned',Auth::id())
                        ->orwhere('user_assigned',NULL);
                        })->where(function($query) {
                    $query->where('user_opened',Auth::id())
                        ->orwhere('user_opened',NULL);
                    })->get();
            }
        }


        return view('home')->with([
                    'helpline'=> $helpline,
                    'fakenews'=> $fakenews,
                    'fakenews_type' => $fakenewstype,
                    'fakenews_source_type' => $fakenewssourcetype,
                    // 'hotline' => $hotline,
                    'resource_types' => $resource_types,
                    'content_types' => $content_types,
                    'references_by' => $references_by,
                    'references_to' => $references_to,
                    'status' => $status,
                    'users' => $users
                ]);
    }
}
