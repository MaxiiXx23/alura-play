<?php

namespace Max\Aluraplay\Domain\Models;

class Video
{

    private ?int $id;
    private string $url;
    private string $title;

    public function __construct(?int $id, string $url, string $title)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getURL(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
