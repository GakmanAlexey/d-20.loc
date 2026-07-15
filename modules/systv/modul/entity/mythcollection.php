<?php

namespace Modules\Systv\Modul\Entity;

class Mythcollection
{
    /**
     * @var \Modules\Systv\Modul\Entity\Myth[]
     */
    private array $myths = [];


    /**
     * Добавить миф в коллекцию
     */
    public function add(\Modules\Systv\Modul\Entity\Myth $myth): Mythcollection
    {
        $this->myths[] = $myth;
        return $this;
    }


    /**
     * Получить все мифы
     *
     * @return Myth[]
     */
    public function getAll(): array
    {
        return $this->myths;
    }


    /**
     * Получить количество мифов
     */
    public function count(): int
    {
        return count($this->myths);
    }


    /**
     * Найти миф по ID
     */
    public function findById(int $id): ?\Modules\Systv\Modul\Entity\Myth
    {
        foreach ($this->myths as $myth) {
            if ($myth->getId() === $id) {
                return $myth;
            }
        }

        return null;
    }


    /**
     * Получить миф по позиции в массиве
     */
    public function get(int $index): ?\Modules\Systv\Modul\Entity\Myth
    {
        return $this->myths[$index] ?? null;
    }


    /**
     * Удалить миф по ID
     */
    public function removeById(int $id): Mythcollection
    {
        foreach ($this->myths as $key => $myth) {
            if ($myth->getId() === $id) {
                unset($this->myths[$key]);
            }
        }

        $this->myths = array_values($this->myths);

        return $this;
    }


    /**
     * Очистить коллекцию
     */
    public function clear(): Mythcollection
    {
        $this->myths = [];
        return $this;
    }
}