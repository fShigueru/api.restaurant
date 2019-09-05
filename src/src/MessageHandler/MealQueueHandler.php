<?php


namespace App\MessageHandler;


use App\Message\MealQueue;
use App\Service\MealService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\HttpClient\HttpClient;
use App\Service\RestaurantService;

class MealQueueHandler implements MessageHandlerInterface
{

    /* @var MealService */
    private $mealService;

    /**
     * MealQueueHandler constructor.
     * @param MealService $mealService
     */
    public function __construct(MealService $mealService)
    {
        $this->mealService = $mealService;
    }

    public function __invoke(MealQueue $message)
    {
        $meal = $this->mealService->findById($message->getContent());
        if (empty($meal)) {
            echo 'Meal não existe';
        } else {
            $httpClient = HttpClient::create();
            $response = $httpClient->request('POST', 'http://172.26.0.12/api/meal', [
                'json' => ['meal' => $meal]
            ]);

            $contents = $response->getContent();
            dump($contents);
        }
    }
}