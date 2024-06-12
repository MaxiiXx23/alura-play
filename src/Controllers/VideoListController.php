<?php

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoListController extends RenderHTMLController implements RequestHandlerInterface
{

    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $videos = $this->videoRepository->getAll();
        $content = $this->renderTemplate('list-videos', ["videos" => $videos]);

        return new Response(status: 200, body: $content);
    }
}
