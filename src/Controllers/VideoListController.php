<?php

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use PDO;

class VideoListController extends RenderHTMLController
{

    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function execute()
    {

        $videos = $this->videoRepository->getAll();
        echo $this->renderTemplate('list-videos', ["videos" => $videos]);
    }
}
