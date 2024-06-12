<?php

namespace Max\Aluraplay\Utils;

use finfo;
use Max\Aluraplay\Domain\Models\Video;

class Upload
{
    public static function execute(Video $video): void
    {
        if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {

            // Aqui evito ataques no "nome" do arquivo
            // pegando somento o "image.png" em vez de(por exemplo): "../../algo-mal-intencionado/image.png
            $safeFileName = pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);

            $fileInfo = new finfo(FILEINFO_MIME_TYPE);

            // Aqui verifco se realmente o arquivo é do tipo IMAGE/*
            // verifcando através do bytes do arquivo, assim, evitando ataques
            $mineType = $fileInfo->file($_FILES['image']['tmp_name']);

            if (str_starts_with($mineType, "image/")) {
                $imageName = uniqid() . "-" . $safeFileName;

                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . "/../../public/img/uploads/" . $imageName
                );

                $video->setFilePath($imageName);
            }
        }
    }
}
