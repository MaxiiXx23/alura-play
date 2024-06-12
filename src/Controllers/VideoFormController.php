<?php

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController extends RenderHTMLController implements RequestHandlerInterface
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
        $videoFound = new Video(null, "", "", null);
        if ($id) {
            $videoFound = $this->videoRepository->getById($id);
        }

        $content = $this->renderTemplate('form-video', ['video' => $videoFound, 'id' => $id]);

        return new Response(status: 200, body: $content);
    }
}
