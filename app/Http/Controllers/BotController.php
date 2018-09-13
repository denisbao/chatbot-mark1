<?php

namespace App\Http\Controllers;

/*
 * testando
 */

use CodeBot\CallSendApi;
use CodeBot\Message\Audio;
use CodeBot\Message\File;
use CodeBot\Message\Image;
use CodeBot\Message\Text;
use CodeBot\Message\Video;
use CodeBot\SenderRequest;
use CodeBot\WebHook;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function subscribe()
    {
        $webhook = new WebHook();
        $subscribe = $webhook->check(config('botfb.validationToken'));

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

        //TESTE PARA ENVIO DE TEXTO:
        $callSendApi->make($text->message('Olá, eu sou um bot...'));
        $callSendApi->make($text->message('Você digitou: '. $message));

//        //TESTE PARA ENVIO DE AUDIO:
//        $message = new Audio($senderId);
//        $callSendApi->make($text->message($message->message('https://d1nhio0ox7pgb.cloudfront.net/_img/g_collection_png/standard/256x256/robot.png')));
//
//        //TESTE PARA ENVIO DE ARQUIVOS:
//        $message = new File($senderId);
//        $callSendApi->make($text->message($message->message('https://d1nhio0ox7pgb.cloudfront.net/_img/g_collection_png/standard/256x256/robot.png')));
//
//        //TESTE PARA ENVIO DE VIDEOS:
//        $message = new Video($senderId);
//        $callSendApi->make($text->message($message->message('https://d1nhio0ox7pgb.cloudfront.net/_img/g_collection_png/standard/256x256/robot.png')));

        //TESTE PARA ENVIO DE IMAGENS:
        $message = new Image($senderId);
        $callSendApi->make($text->message($message->message('https://boiling-dawn-10043.herokuapp.com/img/robot.png')));


    }
}
