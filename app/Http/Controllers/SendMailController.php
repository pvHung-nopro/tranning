<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SendMailRequest;
use App\Services\SendMail\SendMailServiceInterface;
use App\Facades\Response;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailSale;
use Illuminate\Mail\Events\MessageSending;

class SendMailController extends Controller
{
    private SendMailServiceInterface $sendMailService;

    public function __construct(SendMailServiceInterface $sendMailService)
    {
        $this->sendMailService = $sendMailService;
    }

    public function sendMail(SendMailRequest $request): JsonResponse
    {
        $data = $this->sendMailService->sendMail($request->all('context'));
        if (!$data) {
            return  Response::failure();
        }
        return Response::success([
            'context_id' =>  $data->id
        ]);
    }

    public function history(int $id)
    {
        $data = $this->sendMailService->history($id);
        return Response::success($data);
    }

    public function sendToMail(int $id)
    {
       $data = $this->sendMailService->sendToMail($id);
    }







    public function test(MessageSending $event)
    {
        // $user = Mail::to(['pham.van.hung-b@sun-asterisk.com'])->send(new MailSale('aa', 'bbbb'));


        Mail::raw('aaaa', function ($message) {
            $message->from('yourEmail@domain.com', 'Learning Laravel');
            $message->to('pham.van.hung-b@sun-asterisk.com');
            $message->subject('Learning Laravel test email');
        });
        $message = $event->message;
        dd($message);
        // check for failures
        // if (Mail::failures()) {
        //     dd(1);
        // }
    }
}
