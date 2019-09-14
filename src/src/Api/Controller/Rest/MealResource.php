<?php

namespace App\Api\Controller\Rest;

use App\Message\MealQueue;
use App\Repository\MealRepository;
use App\Service\MealService;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Messenger\MessageBusInterface;

class MealResource extends FOSRestBundle
{

    /**
     * Creates an Meal resource
     * @Rest\Post("/meal")
     * @param Request $request
     * @return View
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     description="Meal name"
     * )
     * @SWG\Parameter(
     *     name="description",
     *     in="query",
     *     type="string",
     *     description="meal description"
     * )
     * @SWG\Parameter(
     *     name="image",
     *     in="query",
     *     type="string",
     *     description="URL image"
     * )
     * @SWG\Parameter(
     *     name="position",
     *     in="query",
     *     type="integer",
     *     description="meal position"
     * )
     * @SWG\Parameter(
     *     name="category",
     *     in="query",
     *     type="integer",
     *     description="ID da categoria"
     * )
     * @SWG\Parameter(
     *     name="restaurant",
     *     in="query",
     *     type="integer",
     *     description="ID do restaurante"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return message confirmation",
     * )
     * @SWG\Tag(name="Meal")
     */
    public function create(Request $request, MealService $mealService): View
    {
        try{
            $meal = $mealService->create($request);
            return View::create(['message' => sprintf('Meal create success! %s', $meal->getId())], Response::HTTP_OK);
        }catch (\Exception $exception) {
            return View::create($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Meal and variation
     * @Rest\Get("/meal/{id}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     * )
     * @SWG\Tag(name="Meal")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findById(Request $request, MealService $mealService) : View
    {
        return View::create($mealService->findById($request->get('id')), Response::HTTP_OK);
    }


    /**
     * put restaurant in line
     * @Rest\Get("/meal/send/{id}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     * @SWG\Tag(name="Meal")
     */
    public function queueMeal(Request $request, MealRepository $mealRepository, MessageBusInterface $bus) : View
    {
        $meal = $mealRepository->count(['id' => $request->get('id')]);
        if (!empty($meal)) {
            $bus->dispatch(new MealQueue($request->get('id')));
            return View::create(['message' => 'Meal queue ok!'], Response::HTTP_OK);
        }
        return View::create(['message' => 'Meal does not exist'], Response::HTTP_NOT_FOUND);
    }

    /**
     * put restaurant in line
     * @Rest\Get("/meal/factory/{type}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns meal factory"
     * )
     * @SWG\Tag(name="Meal")
     */
    public function factory(Request $request, MealService $mealService) : View
    {
        $mealFactory = $mealService->factory($request->get('type'));

        return View::create(['message' => $mealFactory->message(), 'class' => get_class($mealFactory)], Response::HTTP_OK);
    }


}