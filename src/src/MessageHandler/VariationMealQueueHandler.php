<?php


namespace App\MessageHandler;

use App\Message\VariationMealQueue;
use App\Service\VariationMealService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\HttpClient\HttpClient;
use WowApps\SlackBundle\DTO\SlackMessage;
use WowApps\SlackBundle\Service\SlackBot;

class VariationMealQueueHandler implements MessageHandlerInterface
{

    /* @var VariationMealService */
    private $variationMealService;

    /* @var SlackBot */
    private $slackBot;

    /**
     * VariationMealQueueHandler constructor.
     * @param VariationMealService $variationMealService
     * @param SlackBot $slackBot
     */
    public function __construct(VariationMealService $variationMealService, SlackBot $slackBot)
    {
        $this->variationMealService = $variationMealService;
        $this->slackBot = $slackBot;
    }

    public function __invoke(VariationMealQueue $message)
    {
        $variation = $this->variationMealService->findByIdModelSearch($message->getContent());
        if (empty($variation)) {
            echo 'Variação não existe';
        } else {
            try{
                $httpClient = HttpClient::create();
                $response = $httpClient->request('POST', sprintf('http://%s/meal', $_ENV['API_SEARCH']), [
                    'json' => $variation
                ]);
            }catch (\Exception $e) {
                print_r($e->getMessage());
            }

            if ($response->getStatusCode() == 200) {
                $slackMessage = new SlackMessage($response->getContent());
                $this->slackBot->send($slackMessage);
            }

            $contents = $response->getContent();
            dump($contents);
            dump($response->getStatusCode());
        }
    }
}