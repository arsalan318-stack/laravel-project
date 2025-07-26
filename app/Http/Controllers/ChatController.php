<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Events\TypingEvent;
use App\Conversations;
use App\Message;
use App\Product;
use App\User;

class ChatController extends Controller
{
    public function chat($productId, $receiverId)
{
    $senderId = auth()->id();

    // Ensure same conversation no matter who starts the chat
    $conversation = Conversations::where(function ($query) use ($senderId, $receiverId, $productId) {
        $query->where('sender_id', $senderId)
              ->where('receiver_id', $receiverId)
              ->where('product_id', $productId);
    })->orWhere(function ($query) use ($senderId, $receiverId, $productId) {
        $query->where('sender_id', $receiverId)
              ->where('receiver_id', $senderId)
              ->where('product_id', $productId);
    })->first();

    if (!$conversation) {
        $conversation = Conversations::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'product_id' => $productId,
        ]);
    }
    $product = Product::findOrFail($productId);
    $messages = Message::where('conversation_id', $conversation->id)->get();

    return view('Users.chat.chat', compact('conversation', 'product', 'messages'));
}

    public function inbox() {
        $userId = auth()->id();

    $conversations = Conversations::with(['product', 'sender', 'receiver'])
        ->where('sender_id', $userId)
        ->orWhere('receiver_id', $userId)
        ->orderBy('updated_at', 'desc')
        ->get()
        ->map(function ($conv) use ($userId) {
            $conv->unread_count = Message::where('conversation_id', $conv->id)
                ->where('sender_id', '!=', $userId)
                ->where('is_read', false)
                ->count();
            return $conv;
        });

    return view('Users.chat.chat_inbox', compact('conversations'));
    }

    public function send(Request $request) {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
        ]);
    
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_read' => false,
        ]);
        $conversation = $message->conversation;

        // Determine the receiver (opposite of sender)
        $receiverId = $conversation->sender_id == auth()->id()
            ? $conversation->receiver_id
            : $conversation->sender_id;
    
        $receiver = User::find($receiverId);
    
        broadcast(new MessageSent($message,$receiver))->toOthers();
    
        return response()->json(['status' => 'Message sent','message' => $message ]);
    }

    public function fetch($conversationId)
    {
        $messages = Message::with('sender')
        ->where('conversation_id', $conversationId)
        ->orderBy('created_at')
        ->get();

    return response()->json($messages);
    }

    public function loadChat($conversationId)
{
    $conversation = \App\Conversations::with(['product', 'sender', 'receiver'])->findOrFail($conversationId);
    $product = $conversation->product;
    $messages = \App\Message::where('conversation_id', $conversationId)->get();

    $otherUser = $conversation->sender_id == auth()->id()
        ? $conversation->receiver
        : $conversation->sender;

    return view('Users.chat.chat_panel', compact('conversation', 'messages', 'product', 'otherUser'));
}

public function markAsRead(Request $request)
{
    \App\Message::where('conversation_id', $request->conversation_id)
        ->where('sender_id', '!=', auth()->id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['status' => 'ok']);
}

public function typing(Request $request)
{
    $user = auth()->user();

    broadcast(new TypingEvent(
        $request->conversation_id,
        $user->id,
        $user->name
    ))->toOthers();

    return response()->json(['status' => 'typing']);
}

}
