<?php

namespace Modules\Systv\Modul\Entity;

class Eracollection
{
    /**
     * @var \Modules\Systv\Modul\Entity\Era[]
     */
    private array $eras = [];


    /**
     * Добавить эру в коллекцию
     */
    public function add(\Modules\Systv\Modul\Entity\Era $era): Eracollection
    {
        $this->eras[] = $era;
        return $this;
    }


    /**
     * Получить все эры
     *
     * @return Era[]
     */
    public function getAll(): array
    {
        return $this->eras;
    }


    /**
     * Получить количество эр
     */
    public function count(): int
    {
        return count($this->eras);
    }


    /**
     * Найти эру по ID
     */
    public function findById(int $id): ?\Modules\Systv\Modul\Entity\Era
    {
        foreach ($this->eras as $era) {
            if ($era->getId() === $id) {
                return $era;
            }
        }

        return null;
    }


    /**
     * Получить эру по позиции в массиве
     */
    public function get(int $index): ?\Modules\Systv\Modul\Entity\Era
    {
        return $this->eras[$index] ?? null;
    }


    /**
     * Удалить эру по ID
     */
    public function removeById(int $id): Eracollection
    {
        foreach ($this->eras as $key => $era) {
            if ($era->getId() === $id) {
                unset($this->eras[$key]);
            }
        }

        $this->eras = array_values($this->eras);

        return $this;
    }


    /**
     * Очистить коллекцию
     */
    public function clear(): Eracollection
    {
        $this->eras = [];
        return $this;
    }
}