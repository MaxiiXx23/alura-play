<?php

namespace Max\Aluraplay\Controllers;

use Exception;
use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Max\Aluraplay\Traits\ErrorMessageTrait;
use Max\Aluraplay\Utils\Upload;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AddVideoController implements RequestHandlerInterface
{
    // Agora estou usando uma Trait(espécie de "Hook" do react)
    use ErrorMessageTrait;
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $body = $request->getParsedBody();

        $url = filter_var($body['url'], FILTER_VALIDATE_URL);
        $title = filter_var($body['title']);

        if (!$url || !$title) {
            // usando o trait("hook") para usar definir o error
            $this->setErrorMessage("Dados inválidos informados.");
            return new Response(200, ["Location" => "/"]);
        }

        $newVideo = new Video(null, $url, $title, null);

        Upload::execute($newVideo);

        try {

            $this->videoRepository->create($newVideo);
            return new Response(200, ["Location" => "/"]);
        } catch (Exception $e) {
            $this->setErrorMessage("Dados ao adicionar vídeo.");
            return new Response(500, ["Location" => "/add-video"]);
        }
    }
}
