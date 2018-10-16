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
use CodeBot\Build\Solid;
use CodeBot\Message\Video;
use CodeBot\SenderRequest;
use CodeBot\Element\Button;
use CodeBot\Element\Product;
use CodeBot\TemplatesMessage\ButtonsTemplate;
use CodeBot\TemplatesMessage\GenericTemplate;
use CodeBot\TemplatesMessage\ListTemplate;
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
        $postback = $sender->getPostback();

        $bot = Solid::factory();
        Solid::pageAccessToken(config('botfb.pageAccessToken'));
        Solid::setSender($senderId);

        if ($postback){
            if (is_array($postback)){
                $postback = json_encode($postback);
            }
            $bot->message('text', 'Você chamou o postback' . $postback);
            return '';
        }

        // TESTE: ENVIO DE TEXTO:
        $bot->message('text','Olá, eu sou um bot...');
        $bot->message('text','Você acabou de digitar:' . $message);

        // TESTE: ENVIO DE IMAGEM:
        $bot->message('text','Vou testar uma imagem');
        $bot->message('image', 'https://boiling-dawn-10043.herokuapp.com/img/robot.png');

        // TESTE: TEMPLATE DE BOTÕES:
        $bot->message('text','Vou testar alguns botões');
        $buttons = [
            new Button('web_url', '9Gag', 'https://www.9gag.com'),
            new Button('web_url', 'Google', 'https://www.google.com'),
        ];
        $bot->template('buttons', 'Quer visitar algum site?', $buttons);

        // TESTE: TEMPLATE DE CARROCEL:
        $bot->message('text','Vou testar um carrocel');
        $products = [
            new Product(
                'produto1',
                'https://support.apple.com/library/content/dam/edam/applecare/images/en_US/homepod/watch-product-lockup-callout.png',
                'Apple',
                new Button('web_url', null, 'http://www.apple.com')
            ),
            new Product(
                'produto2',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/9GAG_new_logo.svg/320px-9GAG_new_logo.svg.png',
                '9Gag',
                new Button('web_url', null, 'http://www.9gag.com')
            )
        ];
        $bot->template('generic', 'Confira esses produtos?', $products);

        //TESTE: TEMPLATE DE LISTA:
        $bot->template('list', 'Confira essa lista produtos!', $products);

    }
}
