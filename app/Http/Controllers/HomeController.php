<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpline;
use App\Hotline;
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

        // $actionsTaken = ActionTaken::all();
        // $actions = ActionTaken::all();
        // if (count($request->actionsTaken)>0){
        //     $act = $request->actionsTaken;
        // } else {
        //     $act = $actions;
        // }

        $request->flash();

        // --------------- //
        // APPLY FILTERING //
        if ($request->filterStatus) {
            $statusSelected = $request->filterStatus;

            // ...set filters but dont get resuts yet, due to pagination and export conflict
            //check user permissions
            $user = auth()->user();
            $IsUserOperator=$user->checkRole("operator") ;
            // dd($IsUserManager);
            if (!$IsUserOperator) {
                $hotline = Hotline::all();
                $helpline = Helpline::ofStatus($statusSelected)->get();
                // $helpline = Helpline::whereStatus($statusSelected)->get();
            }
            else {
                $hotline = Hotline::all();
                if ($statusSelected!="*") {
                    $helpline = Helpline::where('status', '=', $statusSelected)
                        ->where(function ($query) {
                            $query->where('user_assigned', Auth::id())
                                ->orwhere('user_assigned', NULL)
                                ->orwhere('forwarded', "true");
                        })->where(function($query) {
                             $query->where('user_opened', Auth::id())
                                ->orwhere('user_opened',NULL)
                                ->orwhere('forwarded', "true");
                        })
                        ->get();
                }
                else {
                    $helpline = Helpline::ofStatus("*")->where(function ($query) {
                            $query->where('user_assigned', Auth::id())
                                ->orwhere('user_assigned', NULL)
                                ->orwhere('forwarded', "true");
                    })->where(function($query) {
                            $query->where('user_opened', Auth::id())
                                ->orwhere('user_opened', NULL)
                                ->orwhere('forwarded', "true");
                        })
                        ->get();
                }
            }
        } else {
            //check user permissions
            $user = auth()->user();
            $IsUserOperator=$user->checkRole("operator") ;
            // dd($IsUserManager);
            if (!$IsUserOperator) {
                // ...set filters but dont get resuts yet, due to pagination and export conflict
                $hotline = Hotline::all();
                $helpline = Helpline::ofStatus("*")->get();
            }
            else {
                $hotline = Hotline::all();
                $helpline = Helpline::where('status','!=','Closed')
                ->where(function ($query) {
                    $query->where('user_assigned',Auth::id())
                        ->orwhere('user_assigned',NULL)
                        ->orwhere('forwarded', "true");
                        })->where(function($query) {
                        $query->where('user_opened',Auth::id())
                        ->orwhere('user_opened',NULL)
                        ->orwhere('forwarded', "true");
                    })
                ->get();
            }
        }

        return view('home')->with([
                    'helpline'=> $helpline,
                    'hotline' => $hotline,
                    'resource_types' => $resource_types,
                    'content_types' => $content_types,
                    'references_by' => $references_by,
                    'references_to' => $references_to,
                    'status' => $status,
                    'users' => $users
                ]);

        // if ($status->contains('name',$request->sortStatus) || $request->sortStatus == "*") {

        //     if($request->sortStatus == "*") {
        //         if($request->sortUser == "*" && $request->sortUser=="default" || $request->sortUser=="*"){
        //             $helpline = Helpline::all();
        //         } else if($request->sortUser != "default") {
        //             $helpline = Helpline::where('user_id',$request->sortUser)->get();
        //         } else if($request->sortUser == "*" && $request->sortUser=="default" ) {
        //         $helpline = Helpline::all();
        //         }
        //     } else if ($request->sortStatus != "*" && $request->sortUser =="default" || $request->sortUser=="*") {
        //         $helpline = Helpline::where('status',$request->sortStatus)->get();
        //     } else if ($request->sortStatus != "*" && $request->sortUser !="default" && $request->sortUser!="*") {
        //         $helpline = Helpline::where('status',$request->sortStatus)->where('user_id',$request->sortUser)->get();
        //     } else {
        //         $helpline = Helpline::all();
        //     }

        //     $hotline = Hotline::all();
        //     // $resource_types = ResourceType::all();
        //     // $content_types  = ContentType::all();

        //     return view('home')->with([
        //         'helpline'=> $helpline, 
        //         'hotline' => $hotline,
        //         'resource_types' => $resource_types, 
        //         'content_types' => $content_types,
        //         'references_by' => $references_by, 
        //         'references_to' => $references_to,
        //         'status' => $status, 
        //         'users' => $users , 
        //         'actions' => $actions
        //     ]);

        // } else {
        //     $hotline = Hotline::all();

        //     $helpline = Helpline::where('status','!=','Closed')
        //         ->where(function ($query) {
        //             $query->where('user_assigned',Auth::id())
        //                   ->orwhere('user_assigned',NULL)
        //                   ->where('user_opened',Auth::id())
        //                   ->orwhere('user_opened',NULL);
        //             })
        //         ->get();

        //     // $resourcetypes = ResourceType::all();
        //     // $contenttypes  = ContentType::all();

        //     return view('home')->with([
        //         'helpline'=> $helpline , 'hotline' => $hotline,
        //         'resource_types' => $resource_types, 'content_types' => $content_types,
        //         'references_by' => $references_by, 'references_to' => $references_to,
        //         'status' => $status, 'users' => $users, 'actions' => $actions
        //     ]);
        // }
    }
}
