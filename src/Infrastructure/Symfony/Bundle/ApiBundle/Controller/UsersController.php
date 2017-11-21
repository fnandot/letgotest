<?php


namespace LetShout\Infrastructure\Symfony\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use League\Tactician\CommandBus;
use LetShout\Application\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UsersController
 *
 * @Rest\RouteResource("users")
 */
class UsersController extends FOSRestController
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Rest\QueryParam(name="count", requirements="\d+", default="10", description="Number of tweets.")
     */
    public function getTweetsAction(string $username, ParamFetcher $paramFetcher)
    {
        $data = $this
            ->commandBus
            ->handle(
                new GetLastUserTweetsCommand(
                    $username,
                    $paramFetcher->get('count')
                )
            );

        $view = $this->view($data);

        return $this->handleView($view);
    }
}
