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

class EditVideoController implements RequestHandlerInterface
{
    use ErrorMessageTrait;
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $body = $request->getParsedBody();

        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        $url = filter_var($body['url'], FILTER_VALIDATE_URL);
        $title = filter_var($body['title']);

        if (!$id) {
            return new Response(400, ["Location" => "/"]);
        }

        if (!$url || !$title) {
            // usando o trait("hook") para usar definir o error
            $this->setErrorMessage("Dados inválidos informados.");
            $urlEndpoint = "/edit-video?id=$id";
            return new Response(400, ["Location" => $urlEndpoint]);
        }

        $updateVideo = new Video($id, $url, $title, null);

        Upload::execute($updateVideo);

        try {

            if ($updateVideo->getFilePath()) {

                $this->videoRepository->update($updateVideo);
                $this->videoRepository->updateThumbnail($updateVideo);
                $imagePathDelete = __DIR__ . "/../../public/img/uploads/" . $_POST['delete_file'];
                if (file_exists($imagePathDelete)) {
                    unlink($imagePathDelete);
                } else {

                    echo "File does not exists";
                }
            } else {
                $this->videoRepository->update($updateVideo);
            }

            return new Response(200, ["Location" => "/"]);
        } catch (Exception $e) {
            $this->setErrorMessage("Dados ao editar vídeo.");
            return new Response(200, ["Location" => "/edit-video"]);
        }
    }
}
