<?php

namespace App\Http\Controllers;

use App\BotResources\SendSuggestions;
// use App\BotResources\FindEntity;
use App\Postback;
use App\Repositories\MessagesBuilderRepository;
use CodeBot\Build\Solid;
use CodeBot\Resources\Resolver;
use CodeBot\SenderRequest;
use CodeBot\WebHook;
use Illuminate\Http\Request;
use Jshannon63\JsonCollect\JsonCollect;


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


        \Log::info("#####  -  PRINT REQUEST = ".$request);


        $sender = new SenderRequest;
        $senderId = $sender->getSenderId();
        $postback = $sender->getPostback();

        $bot = Solid::factory();
        Solid::pageAccessToken(config('botfb.pageAccessToken'));
        Solid::setSender($senderId);


        if($postback === 'suggestion') {
            (new SendSuggestions)->statusStart($sender, $bot);
            return '';
        }

        $postback = Postback::where('value', $postback)->first();

        if (!$postback) {
            $botResourcesResolver = new Resolver;
            $botResourcesResolver->register(SendSuggestions::class);

            $event = file_get_contents("php://input");
            $event = json_decode($event, true, 512, JSON_BIGINT_AS_STRING);
            $entities = $event['entry'][0]['messaging'][0]['message']['nlp']['entities'];
            $arryEntities = collect($entities);
            $keys = $arryEntities->keys()->first();

            if ($botResourcesResolver->resolver($sender, $bot)) {
                return '';
            }

            if ($keys === "saudacao"){
              $bot->message('text', 'Oi, tudo bem? É um prazer poder lhe atender. Use o menu ao lado para ver as opções disponíveis.');
              \Log::info("#####  -  PRINT RESPOSTA = ".$bot);

            }
            else if ($keys === "teste"){
              $bot->message('text', 'Claro! Quanto mais eu for testado, mais eu vou aprender! :)');
            }
            else if ($keys === "despedida"){
              $bot->message('text', 'Foi um prazer poder lhe ajudar! Volte sempre! :)');
            }
            else {
              $bot->message('text', 'Desculpe, eu ainda estou aprendendo. Não entendi o que você quis dizer...');
              $bot->message('text', 'Use o menu ao lado para ver as opções disponíveis.');
            }
            return '';

        }

        foreach ($postback->messages as $message) {
            (new MessagesBuilderRepository)->createMessage($bot, $message);

            \Log::info("#####  -  PRINT RESPOSTA = ".$message);
        }

        return '';
    }


}
