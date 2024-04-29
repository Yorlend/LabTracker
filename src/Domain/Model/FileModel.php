<?php

namespace App\Domain\Model;

/**
 *  Сущность дескриптора файла
 */
readonly class FileModel
{
    /**
     * @param int $id
     * @param string $name Название файла
     * @param string $path путь к файлу
     * @param int|null $labId id лабы, которой принадлежит файл
     * @param int|null $solutionId id решения, которому принадлежит файл
     */
    public function __construct(
        private int    $id,
        private string $name,
        private string $path,
        private ?int   $labId = null,
        private ?int   $solutionId = null,
    )
    {
    }

    /**
     * @return int id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string имя
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string путь
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int|null id лабы, которой принадлежит файл
     */
    public function getLabId(): ?int
    {
        return $this->labId;
    }

    /**
     * @return int|null id решения, которому принадлежит файл
     */
    public function getSolutionId(): ?int
    {
        return $this->solutionId;
    }
}