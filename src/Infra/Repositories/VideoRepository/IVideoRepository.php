<?php

namespace Max\Aluraplay\Infra\Repositories\VideoRepository;

use Max\Aluraplay\Domain\Models\Video;

interface IVideoRepository
{
    public function getById(int $id): Video;

    /** @return Video[] */
    public function getAll(): array;
    public function create(Video $video): void;
    public function update(Video $video): void;
    public function removeById(int $id): void;
}
