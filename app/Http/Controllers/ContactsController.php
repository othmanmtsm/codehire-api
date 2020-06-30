<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Illuminate\Support\Facades\DB;


class ContactsController extends Controller
{
    public function get()
    {
        $contacts = User::all()->where('id','!=',auth()->user()->id);
        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        $messages = DB::select("select * from messages where (messages.from = ? and messages.to = ?) or (messages.from = ? and messages.to = ?)",[$id,auth()->user()->id,auth()->user()->id,$id]);

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'from' => auth()->user()->id,
            'to' => $request->contact_id,
            'text' => $request->text,
            'type' => $request->type
        ]);

        return response()->json([
            'from' => $message->from,
            'to' => $message->to,
            'text' => $message->text,
            'type' => $message->type,
            'created_at' => date_format($message->created_at, 'Y-m-d h:i:s')
        ]);
    }

    public function sendAttachment(Request $request)
    {
        return $request->file->store('attachments', 'public');
    }
}
