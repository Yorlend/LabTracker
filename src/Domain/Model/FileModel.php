<?php

namespace App\Domain\Model;

readonly class FileModel
{
    /**
     * @param int $id
     * @param string $name Название файла
     * @param int|null $labId id лабы, которой принадлежит файл
     * @param int|null $solutionId id решения, которому принадлежит файл
     */
    public function __construct(
        private int    $id,
        private string $name,
        private ?int   $labId = null,
        private ?int   $solutionId = null,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabId(): ?int
    {
        return $this->labId;
    }

    public function getSolutionId(): ?int
    {
        return $this->solutionId;
    }
}