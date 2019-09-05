<?php


namespace App\MessageHandler;


use App\Message\MealQueue;
use App\Message\VariationMealQueue;
use App\Service\MealService;
use App\Service\VariationMealService;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\HttpClient\HttpClient;
use App\Service\RestaurantService;

class VariationMealQueueHandler implements MessageHandlerInterface
{

    /* @var VariationMealService */
    private $variationMealService;

    /**
     * VariationMealQueueHandler constructor.
     * @param VariationMealService $variationMealService
     */
    public function __construct(VariationMealService $variationMealService)
    {
        $this->variationMealService = $variationMealService;
    }

    public function __invoke(VariationMealQueue $message)
    {
        $variation = $this->variationMealService->findByIdModelSearch($message->getContent());
        if (empty($variation)) {
            echo 'Variação não existe';
        } else {
            $httpClient = HttpClient::create();
            $response = $httpClient->request('POST', sprintf('http://%s/meal', $_ENV['API_SEARCH']), [
                'json' => $variation
            ]);

            $contents = $response->getContent();
            dump($contents);
        }
    }
}