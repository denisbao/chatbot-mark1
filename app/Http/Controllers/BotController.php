<?php

namespace App\Http\Controllers;

/*
 * testando
 */

use CodeBot\CallSendApi;
use CodeBot\Message\Text;
use CodeBot\SenderRequest;
use CodeBot\WebHook;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function subscribe()
    {
        print("subscribe init");
        $webhook = new WebHook();
        $subscribe = $webhook->check(config('botfb.validationToken'));
        print_r($webhook);
        print_r($subscribe);
        dd($subscribe);
        if (!$subscribe){
                abort(403, "Unauthorized action.");
        }
        return $subscribe;
    }

    public function receiveMessage(Request $request)
    {
        $sender = new SenderRequest;
        $senderId = $sender->getSenderId();
        $message = $sender->getMessage();

        $text = new Text($senderId);
        $callSendApi = new CallSendApi(config('botfb.pageAccessToken'));

        $callSendApi->make($text->message('Olá, eu sou um bot...'));
        $callSendApi->make($text->message('Você digitou: '. $message));

        $message = new Image($senderId);
        $callSendApi->make($text->message('Você digitou: '. $message->message('http://testing-companies.com/wp-content/uploads/2017/03/TEST.png')));
        return '';
    }
}
