<?php

namespace TwitterLite\Http\Controllers\API;

use TwitterLite\Message;
USE TwitterLite\Http\Resources\MessageResource;
use Illuminate\Http\Request;
use TwitterLite\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MessageResource::collection(Message::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = Auth::user()->messages()->create($request->input());
        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \TwitterLite\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return new MessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \TwitterLite\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        if ($message->user != Auth::user()) {
            throw new AuthorizationException();
        }
        $message->update($request->input());
        return new MessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \TwitterLite\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        if ($message->user != Auth::user()) {
            throw new AuthorizationException();
        }
        $message->delete();
    }
}