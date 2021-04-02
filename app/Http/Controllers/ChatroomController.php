<?php

namespace App\Http\Controllers;

use App\Chatroom;
use App\GroupPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Response;

class ChatroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $active = Chatroom::orderBy('id', 'DESC')->first();
                // console.log($active->ID)
            } catch (\Exception $e) {
                return Response::json($e);
            }

            if ($active->status == '1') {
                return Response::json([
                    'status' => 'established',
                    'receiver' => $active->receiver,
                    'chat_id' => $active->chat_id
                ]);
            } else {
                return Response::json([
                    'status' => 'nope',
                    'receiver' => $active->receiver,
                    'chat_id' => $active->chat_id
                ]);
            }

        } else {
            return redirect('/');
        }
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chatroom $chatroom
     * @return \Illuminate\Http\Response
     */
    public function show($chatid)
    {        
        $users = \DB::table('sessions')->where('user_id', '!=', null)->get();
        $active = Chatroom::orderBy('id', 'DESC')->first();
        
        if ($active->status == 1) {
            if ($active->sender != $chatid) {
                return Response::json([
                    'error' => \Lang::get('translations.chat.operator_busy', array(), Session::get('lang'))
                ]);
            }
        }

        if (count($users) > 1) {
            foreach ($users as $user) {
                if (GroupPermission::canuser($user->user_id, 'view', 'chat')) {
                    return Response::json(true);
                }
            }
        } elseif (count($users) == 1) {
            if (GroupPermission::canuser($users[0]->user_id, 'view', 'chat')) {
                return Response::json(true);
            }
        } else {
            return Response::json(['outofservice' => true]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chatroom $chatroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Chatroom $chatroom)
    {
        $updatechat = Chatroom::where('status', '1')->orderBy('id', 'DESC')->first();
        $updatechat->receiver = $request->receiver;
        $updatechat->save();
         
        return $updatechat;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Chatroom $chatroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chatroom $chatroom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chatroom $chatroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chatroom $chatroom)
    {
        //
    }


}
