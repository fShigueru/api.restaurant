<?php


namespace App\MessageHandler;


use App\Message\RestaurantQueue;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\HttpClient\HttpClient;
use App\Service\RestaurantService;

class RestaurantQueueHandler implements MessageHandlerInterface
{

    /* @var RestaurantService */
    private $restaurantService;

    /**
     * RestaurantQueueHandler constructor.
     * @param RestaurantService $restaurantService
     */
    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function __invoke(RestaurantQueue $message)
    {
        $restaurant = $this->restaurantService->findById($message->getContent());
        if (empty($restaurant)) {
            echo 'Restaurant não existe';
        } else {
            $httpClient = HttpClient::create();
            $response = $httpClient->request('POST', 'http://172.26.0.12/api/restaurant', [
                'json' => ['restaurant' => $restaurant]
            ]);

            $contents = $response->getContent();
            dump($contents);
        }
    }
}