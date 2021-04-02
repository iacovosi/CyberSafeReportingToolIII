<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Response;
use App\Chatroom;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->ajax()){

             Message::create(['chat_id' => $request->chat_id , 'sender' => $request->username , 'message' => $request->message ]);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $chat_id)
    {
        if($request->ajax()){
            $data = Message::where('chat_id',$request->chat_id)->get();            
            
            if($data->isEmpty()){
                return 'empty';
            } else {
                return Response::json($data);
            }

        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editchat = Message::find($id);
        $editchat->append = 1;
        $editchat->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($chatid)
    {
         $active = Chatroom::orderBy('id', 'DESC')->first();

         if($active->status == 1 || $active->chat_id == $chatid){
            $active->status = 0 ;
            $active->save();
            $chatmessages = Message::where('chat_id','=',$chatid)->delete();
            return '';
         }

    }

    public function notify (Request $request){

        $active = Chatroom::orderBy('id', 'DESC')->first();

        if($active->status == 1){
            if($active->sender != $request->chat_id){
                return Response::json(['error'=> 'Sorry some one else is getting served at the moment. Please try again later or send as an email']);
            }
        } else {
          Chatroom::create(['chat_id' => $request->chat_id , 'status' => 1 ,'receiver' => 0, 'sender' => $request->chat_id ]);
          return Response::json('sucess');
        }
    }


}
