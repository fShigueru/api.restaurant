<?php

namespace App\Api\Controller\Rest;

use App\Message\VariationMealQueue;
use App\Repository\VariationMealRepository;
use App\Service\VariationMealService;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Messenger\MessageBusInterface;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;

class VariationMealResource extends FOSRestBundle
{

    /**
     * Creates an Meal resource
     * @Rest\Post("/variation-meal")
     * @param Request $request
     * @return View
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     description="Name of meal variation"
     * )
     * @SWG\Parameter(
     *     name="description",
     *     in="query",
     *     type="string",
     *     description="Description of meal variation"
     * )
     * @SWG\Parameter(
     *     name="price",
     *     in="query",
     *     type="string",
     *     description="price"
     * )
     * @SWG\Parameter(
     *     name="meal",
     *     in="query",
     *     type="integer",
     *     description="ID meal"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns message confirmation",
     * )
     * @SWG\Tag(name="VariationMeal")
     */
    public function create(Request $request, VariationMealService $variationMealService): View
    {
        try{
            $variation = $variationMealService->create($request);
            return View::create(['message' => sprintf('Variation Meal create success! %s', $variation->getId())], Response::HTTP_OK);
        }catch (\Exception $exception) {
            return View::create($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update an Meal resource
     * @Put("/variation-meal/{id}")
     * @param Request $request
     * @return View
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     description="Name of meal variation"
     * )
     * @SWG\Parameter(
     *     name="description",
     *     in="query",
     *     type="string",
     *     description="Description of meal variation"
     * )
     * @SWG\Parameter(
     *     name="price",
     *     in="query",
     *     type="string",
     *     description="price"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns message confirmation",
     * )
     * @SWG\Tag(name="VariationMeal")
     */
    public function update(Request $request, VariationMealService $variationMealService): View
    {
        try{
            $variation = $variationMealService->update($request);
            return View::create(['message' => sprintf('Variation Meal update success! %s', $variation->getId())], Response::HTTP_OK);
        }catch (\Exception $exception) {
            return View::create($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * document delete
     * @Delete("/variation-meal/{id}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns document complete",
     * )
     * @SWG\Tag(name="VariationMeal")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function delete(Request $request, VariationMealService $variationMealService) : View
    {
        try{
            $variationMealService->delete($request);
            return View::create(['message' => 'removido com sucesso'], Response::HTTP_OK);
        }catch (\Exception $exception) {
            return View::create($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Meal and variation
     * @Rest\Get("/variation-meal/{id}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     * )
     * @SWG\Tag(name="VariationMeal")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findById(Request $request, VariationMealService $variationMealService) : View
    {
        return View::create($variationMealService->findById($request->get('id')), Response::HTTP_OK);
    }

    /**
     * document search
     * @Rest\Get("/variation-meal-document/{id}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns document complete",
     * )
     * @SWG\Tag(name="VariationMeal")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByIdModelSearch(Request $request, VariationMealService $variationMealService) : View
    {
        return View::create($variationMealService->findByIdModelSearch($request->get('id')), Response::HTTP_OK);
    }

    /**
     * put variation in line
     * @Rest\Get("/variation-meal-document/send/{id}")
     * @param Request $request
     * @return View
     * @SWG\Response(
     *     response=200,
     *     description="Returns confirmation"
     * )
     * @SWG\Tag(name="VariationMeal")
     */
    public function queueMeal(Request $request, VariationMealRepository $variationMealRepository, MessageBusInterface $bus) : View
    {
        $variation = $variationMealRepository->count(['id' => $request->get('id')]);
        if (!empty($variation)) {
            $bus->dispatch(new VariationMealQueue($request->get('id')));
            return View::create(['message' => 'Document Variation Meal queue ok!'], Response::HTTP_OK);
        }
        return View::create(['message' => 'Variation Meal does not exist'], Response::HTTP_NOT_FOUND);
    }
}