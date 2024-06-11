<?php

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use PDO;

class VideoListController
{

    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function execute()
    {

        $videos = $this->videoRepository->getAll();
        require_once __DIR__ . '/../views/list-videos.php';
    }
}
