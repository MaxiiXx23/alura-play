<?php

namespace Max\Aluraplay\Controllers;

use Exception;
use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;
use Max\Aluraplay\Traits\ErrorMessageTrait;
use Max\Aluraplay\Utils\Upload;
use PDO;

class EditVideoController
{
    use ErrorMessageTrait;
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

        if (!$id) {
            header('Location: /');
            return;
        }

        if (!$url || !$title) {
            // usando o trait("hook") para usar definir o error
            $this->setErrorMessage("Dados inválidos informados.");
            header('Location: /edit-video?id=' . $id);
            return;
        }

        $updateVideo = new Video($id, $url, $title, null);

        Upload::execute($updateVideo);

        try {

            if ($updateVideo->getFilePath()) {

                $this->videoRepository->update($updateVideo);
                $this->videoRepository->updateThumbnail($updateVideo);
                $imagePathDelete = __DIR__ . "/../../public/img/uploads/" . $_POST['delete_file'];
                if (file_exists($imagePathDelete)) {
                    unlink($imagePathDelete);
                } else {

                    echo "File does not exists";
                }
            } else {
                $this->videoRepository->update($updateVideo);
            }

            header('Location: /');
        } catch (Exception $e) {
            $this->setErrorMessage("Dados ao editar vídeo.");
            header('Location: /edit-video');
        }
    }
}
