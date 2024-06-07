<?php

namespace Max\Aluraplay\Controllers;

use Exception;
use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use PDO;

class EditVideoController
{
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function execute()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $title = filter_input(INPUT_POST, 'title');

        if (!$url || !$title || !$id) {
            header('Location: /?sucesso=0');
            return;
        }

        try {

            $updateVideo = new Video($id, $url, $title);

            $this->videoRepository->update($updateVideo);

            header('Location: /?sucesso=0');
        } catch (Exception $e) {
            header('Location: /?sucesso=1');
        }
    }
}
