<?php
declare(strict_types=1);

namespace App\Entity;

class Image
{
    private ?int $id;
    private string $path;

    public function __construct(
        ?int $id,
        string $path)
    {
        $this->id = $id;
        $this->path = $path;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }
}
