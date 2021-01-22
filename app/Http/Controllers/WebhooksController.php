<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhooksController extends Controller
{
    public function status(Request $request)
    {
        $data = $request->all();
        Log::Info($data);
    }

    public function inbound(Request $request)
    {
        $data = $request->all();

        $text = $data['message']['content']['text'];

//        Log::Info($text);
//        dd($text);

        if ($text === "programação" || $text === "Programação" || $text === "programacao") {
            $url = "https://messages-sandbox.nexmo.com/v0.1/messages";
            $headers = ["Authorization" => "Basic " . base64_encode(env('NEXMO_API_KEY') . ":" . env('NEXMO_API_SECRET'))];
            $client = new \GuzzleHttp\Client();

            //todo os parâmetros serão alterados:::
            $params = ["to" => ["type" => "whatsapp", "number" => $data['from']['number']],
                "from" => ["type" => "whatsapp", "number" => "14157386170"],
                "message" => [
                    "content" => [
                        "type" => "text",
                        "text" => "Ótima escolha! Estou enviando a nossa programação é só abrir e conferir. Não esqueça que estamos te esperando de braços abertos em! ;) Confere também o nosso Canal no Youtube: https://www.youtube.com/channel/UCCkSBfP-6i52hQ_GR-0Zz2Q"
                    ]
                ]
            ];


            $response1 = $client->request('POST', $url, ["headers" => $headers, "json" => $params]);

            if ($response1->getStatusCode(200)) {
                $params2 = ["to" => ["type" => "whatsapp", "number" => $data['from']['number']],
                    "from" => ["type" => "whatsapp", "number" => "14157386170"],
                    "message" => [
                        "content" => [
                            "type" => "image",
                            "image" => [
                                "url" => 'https://i.ibb.co/t8TmKcc/fa82a260-ff13-4468-9c41-1ceb5c523e0e.jpg'
                            ]
                        ]
                    ]
                ];


                $response2 = $client->request('POST', $url, ["headers" => $headers, "json" => $params2]);
                $data = $response2->getBody();
                return $data;
            }


        } else{
            $url = "https://messages-sandbox.nexmo.com/v0.1/messages";
            $headers = ["Authorization" => "Basic " . base64_encode(env('NEXMO_API_KEY') . ":" . env('NEXMO_API_SECRET'))];
            $client = new \GuzzleHttp\Client();

            //todo os parâmetros serão alterados:::
            $params = ["to" => ["type" => "whatsapp", "number" => $data['from']['number']],
                "from" => ["type" => "whatsapp", "number" => "14157386170"],
                "message" => [
                    "content" => [
                        "type" => "text",
                        "text" => "Desculpa, ainda não entendemos a sua mensagem! Envie 'programação' ou ligue para o telefone: (61) 9 96617935"
                    ]
                ]
            ];


            $response3 = $client->request('POST', $url, ["headers" => $headers, "json" => $params]);
            return $response3->getBody();
        }
    }
}
