<?php

namespace Max\Aluraplay\Controllers;

use League\Plates\Engine;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoListController implements RequestHandlerInterface
{

    private VideoRepository $videoRepository;
    private Engine $templateEngine;

    public function __construct(PDO $connectionBD, Engine $templateEngine)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
        $this->templateEngine = $templateEngine;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $videos = $this->videoRepository->getAll();
        $content = $this->templateEngine->render('list-videos', ["videos" => $videos]);

        return new Response(status: 200, body: $content);
    }
}
