<?php

namespace Max\Aluraplay\Controllers;

use Exception;
use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Max\Aluraplay\Utils\Upload;
use PDO;

class AddVideoController
{
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
            header('Location: /?sucesso=1');
            return;
        }

        $newVideo = new Video(null, $url, $title, null);

        Upload::execute($newVideo);

        try {

            $this->videoRepository->create($newVideo);

            header('Location: /?sucesso=0');
        } catch (Exception $e) {
            header('Location: /?sucesso=1');
        }
    }
}
