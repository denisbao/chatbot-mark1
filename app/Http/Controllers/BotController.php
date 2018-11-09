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


        //\Log::info("#####  -  PRINT REQUEST = ".$request);

        //$input = $request->input('entry.messaging.message.nlp.entities');

        // $input = $request->all();

        // $input = $request->json()->all();




        // \Log::info("#####  -  PRINT DATA = " . $request->input('0.entities') );
        // \Log::info($request->input('0.entities'));

        //\Log::info("#####  -  PRINT INPUT = ".$data['entities']);
        //\Log::info("#####  -  PRINT CONFIANCE = ".$data['confidence']);

        $event = file_get_contents("php://input");
        $event = json_decode($event, true, 512, JSON_BIGINT_AS_STRING);
        $entities = $event['entry'][0]['messaging'][0]['message']['nlp']['entities'];

        $arryEntities = collect($entities);

        $keys = $arryEntities->keys();



        // $d = new FindEntity;
        // $d->findEntityKeys($entities);
        // $enti = $d[1];


        // foreach($entities as $row) {
        //     foreach($row as $key => $val) {
        //        $saida = $key;
        //     }
        // }


        \Log::info("#####  -  ARRAY DE KEYS = ".$keys);










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
            if ($botResourcesResolver->resolver($sender, $bot)) {
                return '';
            }
            $bot->message('text', 'A entidade é .... ' . $keys.toString());
            $bot->message('text', 'Desculpe, eu não sei o que você quis dizer...');
            $bot->message('text', 'Use o menu ao lado para ver as opções disponíveis.');
            return '';

        }

        foreach ($postback->messages as $message) {
            (new MessagesBuilderRepository)->createMessage($bot, $message);
        }

        return '';
    }


}
