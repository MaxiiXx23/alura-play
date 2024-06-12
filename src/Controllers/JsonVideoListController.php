<?php

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use PDO;

class JsonVideoListController
{
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function execute(): void
    {
        // Como os atributos estão privados, precisamos re-hydratar os dados
        $videoList = array_map(function (Video $video): array {
            return [
                'url' => $video->getURL(),
                'title' => $video->getTitle(),
                'file_path' => '/img/uploads/' . $video->getFilePath(),
            ];
        }, $this->videoRepository->getAll());

        echo json_encode($videoList);
    }
}
