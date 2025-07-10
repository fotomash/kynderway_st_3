<?php

namespace App\Repositories;

use App\Interfaces\MessageInterface;
use Chatify\Http\Models\Message;

class MessageRepository implements MessageInterface
{
    public function getMessageList()
    {
        return Message::with('connection', 'connection.job', 'connection.jobProvider', 'connection.jobPoster')
                    ->whereNull('deleted_at')
                    ->orderBy('id', 'desc')
                    ->get()
                    ->groupBy('reference_id');
    }

    public function getMessages($id)
    {
        return Message::where('reference_id', $id)
                ->orderBy('messages.created_at', 'asc')
                ->get();
    }

    public function getJobDetails($id)
    {
        return Message::with('connection', 'connection.job', 'connection.jobProvider', 'connection.jobPoster')
                    ->where('reference_id', $id)
                    ->first()
                    ->toArray();
    }

    public function delete($id)
    {
        return Message::where('reference_id', $id)->delete();
    }

    public function deleteFromTo($id)
    {
        Message::where('from_id', $id)->delete();
        Message::where('to_id', $id)->delete();
    }
}
