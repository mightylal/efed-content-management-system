<?php

namespace Efed\Http\Controllers;

use Illuminate\Http\Request;
use Efed\Http\Requests;
use Efed\Services\MessageService;
use Efed\Messages\Listing;
use Efed\Messages\Message;
use Efed\Exceptions\ValidationException;

class MessageController extends Controller
{
    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * @var Listing
     */
    private $listing;

    /**
     * @var Message
     */
    private $message;

    /**
     * Start new MessageController.
     *
     * @param MessageService $messageService
     * @param Listing $listing
     * @param Message $message
     */
    public function __construct(MessageService $messageService, Listing $listing, Message $message)
    {
        $this->messageService = $messageService;
        $this->listing = $listing;
        $this->message = $message;
    }
    
    /**
     * Display the messages view.
     * 
     * @return view
     */
    public function index()
    {
        $messages = $this->listing->get($this->wrestlerId());
        return view('messages', compact('messages'));
    }
    
    /**
     * Display the create message view.
     * 
     * @return view
     */
    public function create()
    {
        return view('create_message');
    }

    /**
     * Display the message view.
     * 
     * @param string $id
     * @return view
     */
    public function show($id)
    {
        $this->messageService->viewed(trim($id), $this->wrestlerId());
        $messages = $this->message->get(trim($id), $this->wrestlerId());
        return view('message', compact('messages', 'id'));
    }
    
    /**
     * Create new message.
     * 
     * @param Request $request
     * @return response
     */
    public function storeMessage(Request $request)
    {
        try {
            $this->messageService->create($this->wrestlerId(), array_map('trim', $request->only('name', 'subject', 'message')));
            return redirect()->route('messages')->with('message', 'Message sent successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('messages.create')->withErrors($error->getErrors());
        }
    }
    
    /**
     * Create new reply.
     * 
     * @param string $id
     * @param Request $request
     * @return response
     */
    public function storeReply($id, Request $request)
    {
        try {
            $this->messageService->reply(trim($id), $this->wrestlerId(), array_map('trim', $request->only('message')));
            return redirect()->route('message', ['message' => $id])->with('message', 'Message replied to successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('message', ['message' => $id])->withErrors($error->getErrors());
        }
    }

    /**
     * Delete messages.
     *
     * @param Request $request
     * @return response
     */
    public function destroy(Request $request)
    {
        try {
            $this->messageService->delete($this->wrestlerId(), $request->only('id'));
            return redirect()->route('messages')->with('message', 'Message(s) deleted successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('messages')->withErrors($error->getErrors());
        }
    }
}
