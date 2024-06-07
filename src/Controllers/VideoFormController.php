<?php

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use PDO;

class VideoFormController
{
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function execute()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $videoFound = new Video(null, "", "");
        if ($id) {
            $videoFound = $this->videoRepository->getById($id);
        }

        require_once __DIR__ . '/../views/form-video.php';
    }
}
