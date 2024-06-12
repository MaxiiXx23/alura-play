<?php

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use PDO;

class VideoFormController extends RenderHTMLController
{
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function execute()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $videoFound = new Video(null, "", "", null);
        if ($id) {
            $videoFound = $this->videoRepository->getById($id);
        }

        echo $this->renderTemplate('form-video', ['video' => $videoFound, 'id' => $id]);
    }
}
