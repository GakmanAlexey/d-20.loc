<?php

namespace Modules\Sysdnd\Modul\Entity;

class Sourcecollection
{
    /**
     * @var Source[]
     */
    private array $sources = [];

    /**
     * Добавить источник в коллекцию
     */
    public function add(Source $source): self
    {
        $this->sources[] = $source;
        return $this;
    }

    /**
     * Получить все источники
     *
     * @return Source[]
     */
    public function getAll(): array
    {
        return $this->sources;
    }

    /**
     * Получить количество источников
     */
    public function count(): int
    {
        return count($this->sources);
    }

    /**
     * Найти источник по ID
     */
    public function findById(int $id): ?Source
    {
        foreach ($this->sources as $source) {
            if ($source->getId() === $id) {
                return $source;
            }
        }

        return null;
    }

    /**
     * Получить источник по позиции в массиве
     */
    public function get(int $index): ?Source
    {
        return $this->sources[$index] ?? null;
    }

    /**
     * Удалить источник по ID
     */
    public function removeById(int $id): self
    {
        foreach ($this->sources as $key => $source) {
            if ($source->getId() === $id) {
                unset($this->sources[$key]);
                break;
            }
        }

        $this->sources = array_values($this->sources);

        return $this;
    }

    /**
     * Очистить коллекцию
     */
    public function clear(): self
    {
        $this->sources = [];
        return $this;
    }
}