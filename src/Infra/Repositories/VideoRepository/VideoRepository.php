<?php

namespace Max\Aluraplay\Infra\Repositories\VideoRepository;

use Max\Aluraplay\Domain\Models\Video;
use Max\Aluraplay\Infra\Repositories\VideoRepository\IVideoRepository;
use PDO;
use PDOStatement;

class VideoRepository implements IVideoRepository
{
    private PDO $pdo;

    public function __construct(PDO $connection)
    {
        $this->pdo = $connection;
    }

    public function getById(int $id): Video
    {
        $sqlQuery = "SELECT id, url, title FROM videos WHERE id=:id;";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            ":id" => $id
        ]);

        $videoFound = $this->hydrateVideo($stmt);
        return $videoFound;
    }

    /** @return Video[] */
    public function getAll(): array
    {
        $sqlQuery = "SELECT id, url, title FROM videos;";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute();

        $list = $this->hydrateVideoList($stmt);
        return $list;
    }
    public function create(Video $video): void
    {
        $sqlQuery = "INSERT INTO  videos (url, title) VALUES (:url, :title);";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            ":url" => $video->getURL(),
            ":title" => $video->getTitle(),
        ]);
    }
    public function update(Video $video): void
    {
        $sqlQuery = "UPDATE videos SET url=:url, title=:title WHERE id=:id;";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            ":id" => $video->getId(),
            ":url" => $video->getURL(),
            ":title" => $video->getTitle(),
        ]);
    }
    public function removeById(int $id): void
    {
        $sqlQuery = "DELETE FROM videos WHERE id=:id;";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            ":id" => $id,
        ]);
    }

    private function hydrateVideo(PDOStatement $stmt): Video
    {

        $videoData = $stmt->fetch();

        $video = new Video(
            $videoData['id'],
            $videoData['url'],
            $videoData['title'],
        );
        return $video;
    }

    /** @return Video[] */
    private function hydrateVideoList(PDOStatement $stmt): array
    {

        $videoDataList = $stmt->fetchAll();

        $Hydratedlist = array_map(function ($videoData) {
            $video = new Video(
                $videoData['id'],
                $videoData['url'],
                $videoData['title'],
            );
            return $video;
        }, $videoDataList);

        return $Hydratedlist;
    }
}
