<?php

namespace App\Api\Controller\Rest;

use App\Entity\Restaurant;
use App\Message\RestaurantQueue;
use App\Repository\RestaurantRepository;
use App\Service\RestaurantService;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Messenger\MessageBusInterface;
use WowApps\SlackBundle\DTO\SlackMessage;
use WowApps\SlackBundle\Service\SlackBot;

class RestaurantResource extends FOSRestBundle
{
    /**
     * Creates an Restaurant resource
     * @Rest\Post("/restaurant")
     * @param Request $request
     * @return View
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     description="The field used to order rewards"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Restaurant::class, groups={"full"}))
     *     )
     * )
     * @SWG\Tag(name="Restaurant")
     */
    public function create(Request $request): View
    {
        dump($request);exit;
    }

    /**
     * All from restaurant with meal
     * @Rest\Get("/restaurant")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Restaurant::class, groups={"full"}))
     *     )
     * )
     * @SWG\Tag(name="Restaurant")
     */
    public function findAllFromRestaurant(RestaurantService $restaurantService): View
    {
        return View::create($restaurantService->findAll(), Response::HTTP_OK);
    }

    /**
     * All from restaurant with meal By Id Restaurant
     * @Rest\Get("/restaurant/{id}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Restaurant::class, groups={"full"}))
     *     )
     * )
     * @SWG\Tag(name="Restaurant")
     */
    public function findByIdAllFromRestaurant(Request $request, RestaurantService $restaurantService) : View
    {
        return View::create($restaurantService->findById($request->get('id')), Response::HTTP_OK);
    }

    /**
     * put all restaurant in line
     * @Rest\Get("/restaurant/send/all")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     * @SWG\Tag(name="Restaurant")
     */
    public function queueAllRestaurant(RestaurantRepository $restaurantRepository, MessageBusInterface $bus) : View
    {
        $restaurants = $restaurantRepository->findAll();
        if (!empty($restaurants)) {
            foreach ($restaurants as $restaurant) {
                $bus->dispatch(new RestaurantQueue($restaurant->getId()));
            }
            return View::create(['message' => 'Restaurants queue ok!'], Response::HTTP_OK);
        }
        return View::create(['message' => 'restaurant does not exist'], Response::HTTP_NOT_FOUND);
    }


    /**
     * put restaurant in line
     * @Rest\Get("/restaurant/send/{id}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     * @SWG\Tag(name="Restaurant")
     */
    public function queueRestaurant(Request $request, RestaurantRepository $restaurantRepository, MessageBusInterface $bus) : View
    {
        $restaurant = $restaurantRepository->count(['id' => $request->get('id')]);
        if (!empty($restaurant)) {
            $bus->dispatch(new RestaurantQueue($request->get('id')));
            return View::create(['message' => 'Restaurant queue ok!'], Response::HTTP_OK);
        }
        return View::create(['message' => 'restaurant does not exist'], Response::HTTP_NOT_FOUND);
    }

    /**
     * document search
     * @Rest\Get("/restaurant/state/{id}")
     * @SWG\Response(
     *     response=200,
     *     description="Returns state restaurant",
     * )
     * @SWG\Tag(name="Restaurant")
     * @param Request $request
     * @param RestaurantService $restaurantService
     * @return View
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function state(Request $request, RestaurantService $restaurantService) : View
    {
        $state = $restaurantService->state($request->get('id'));
        return View::create(['Restaurant open: ' => $state->isOpen()], Response::HTTP_OK);
    }

    /**
     * Message slack
     * @Rest\Post("/slack")
     * @param Request $request
     * @return View
     * @SWG\Parameter(
     *     name="message",
     *     in="query",
     *     type="string",
     *     description="Message"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     * @SWG\Tag(name="Slack")
     */
    public function slack(Request $request, SlackBot $slackBot): View
    {
        $slackMessage = new SlackMessage($request->get('message'));
        $slackBot->send($slackMessage);

        return View::create(['Message: ' => 'Mensagem enviada'], Response::HTTP_OK);
    }

}