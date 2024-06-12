<?php

namespace Max\Aluraplay\Controllers;

use Exception;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

// Em vez de Icontroller, colocamos RequestHandlerInterface afim de seguir a PSR-15
// https://www.php-fig.org/psr/psr-15/
class RemoveVideoController implements RequestHandlerInterface
{
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);

        if ($id) {
            try {
                $this->videoRepository->removeById($id);

                return new Response(200, [
                    'Location' => '/'
                ]);
            } catch (Exception $e) {

                // Evianda uma Response (Basicamento a interface Response do Express)
                return new Response(400, [
                    'Location' => '/'
                ]);
            }
        }
    }
}
