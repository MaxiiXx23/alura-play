<?php

namespace Max\Aluraplay\Domain\Models;

class Video
{

    private ?int $id;
    private string $url;
    private string $title;
    private ?string $filePath;

    public function __construct(?int $id, string $url, string $title, ?string $filePath)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->filePath = $filePath;
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

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function getFilePathURL(): ?string
    {
        if (!$this->filePath) {
            return null;
        }
        $path = "/img/uploads/" . $this->filePath;
        return  $path;
    }
}
