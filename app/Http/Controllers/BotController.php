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
use CodeBot\Element\Button;
use CodeBot\TemplatesMessage\ButtonsTemplate;
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

        //TESTE PARA ENVIO DE AUDIO:
        $message = new Audio($senderId);
        $callSendApi->make($text->message('Escuta uma musiquinha ai:'));
        $callSendApi->make($message->message('https://boiling-dawn-10043.herokuapp.com/audio/audio-test.mp3'));

        //TESTE PARA ENVIO DE ARQUIVOS:
        $message = new File($senderId);
        $callSendApi->make($text->message('Confira esse arquivo ai:'));
        $callSendApi->make($message->message('https://boiling-dawn-10043.herokuapp.com/file/arquivo.zip'));

        //TESTE PARA ENVIO DE VIDEOS:
        $message = new Video($senderId);
        $callSendApi->make($text->message('Já viu esse video?'));
        $callSendApi->make($message->message('https://boiling-dawn-10043.herokuapp.com/video/video-test.mp4'));

        //TESTE PARA ENVIO DE IMAGENS:
        $message = new Image($senderId);
        $callSendApi->make($text->message('Quer ver um nude?'));
        $callSendApi->make($message->message('https://boiling-dawn-10043.herokuapp.com/img/robot.png'));

        $message = new ButtonsTemplate($senderId);
        $message->add(new Button('web_url', '(9Gag', 'https://www.9gag.com'));
        $message->add(new Button('web_url', '(Google', 'https://www.google.com'));
        $callSendApi->make($message->message('Testando botões'));

    }
}
