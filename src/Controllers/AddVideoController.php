<?php

namespace Max\Aluraplay\Controllers;

use Exception;
use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
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

        try {

            $newVideo = new Video(null, $url, $title);

            $this->videoRepository->create($newVideo);

            header('Location: /?sucesso=0');
        } catch (Exception $e) {
            header('Location: /?sucesso=1');
        }
    }
}
