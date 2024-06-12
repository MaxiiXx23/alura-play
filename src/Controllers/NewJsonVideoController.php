<?php

declare(strict_types=1);

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;

class NewJsonVideoController
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        // Get Body da Request
        $request = file_get_contents('php://input');
        // Decodificando para Arrays Associativos do PHP, ou seja, um array de objetos se fosse no JS/TS
        $videoData = json_decode($request, true);
        $video = new Video(null, $videoData['url'], $videoData['title'], null);
        $this->videoRepository->create($video);

        http_response_code(201);
    }
}
