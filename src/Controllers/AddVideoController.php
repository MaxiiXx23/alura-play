<?php

namespace Max\Aluraplay\Controllers;

use Exception;
use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Max\Aluraplay\Traits\ErrorMessageTrait;
use Max\Aluraplay\Utils\Upload;
use PDO;

class AddVideoController
{
    // Agora estou usando uma Trait(espécie de "Hook" do react)
    use ErrorMessageTrait;
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function execute()
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $title = filter_input(INPUT_POST, 'title');

        if (!$url || !$title) {
            // usando o trait("hook") para usar definir o error
            $this->setErrorMessage("Dados inválidos informados.");
            header('Location: /add-video');
            return;
        }

        $newVideo = new Video(null, $url, $title, null);

        Upload::execute($newVideo);

        try {

            $this->videoRepository->create($newVideo);

            header('Location: /');
        } catch (Exception $e) {
            $this->setErrorMessage("Dados ao adicionar vídeo.");
            header('Location: /add-video');
        }
    }
}
