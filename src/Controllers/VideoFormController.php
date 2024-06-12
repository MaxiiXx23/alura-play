<?php

namespace Max\Aluraplay\Controllers;

use League\Plates\Engine;
use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController implements RequestHandlerInterface
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
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        $videoFound = new Video(null, "", "", null);
        if ($id) {
            $videoFound = $this->videoRepository->getById($id);
        }

        $content = $this->templateEngine->render('form-video', ['video' => $videoFound, 'id' => $id]);

        return new Response(status: 200, body: $content);
    }
}
