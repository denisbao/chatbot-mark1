<?php

namespace App\Http\Controllers;

use App\BotResources\SendSuggestions;
use App\Postback;
use App\Repositories\MessagesBuilderRepository;
use CodeBot\Build\Solid;
use CodeBot\Resources\Resolver;
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
