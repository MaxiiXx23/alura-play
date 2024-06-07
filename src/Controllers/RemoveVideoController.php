<?php

namespace Max\Aluraplay\Controllers;

use Exception;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use PDO;

class RemoveVideoController
{
    private VideoRepository $videoRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->videoRepository = new VideoRepository($connectionBD);
    }

    public function execute()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            try {
                $this->videoRepository->removeById($id);

                header("Location: /?sucess=0");
            } catch (Exception $e) {
                echo "Erro";
                exit();
            }
        }
    }
}
