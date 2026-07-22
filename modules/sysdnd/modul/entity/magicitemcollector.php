<?php

namespace Modules\Sysdnd\Modul\Entity;

class Magicitemcollection
{
    /**
     * @var MagicItem[]
     */
    private array $magicItems = [];

    /**
     * Добавить предмет в коллекцию
     */
    public function add(MagicItem $magicItem): self
    {
        $this->magicItems[] = $magicItem;
        return $this;
    }

    /**
     * Получить все предметы
     *
     * @return MagicItem[]
     */
    public function getAll(): array
    {
        return $this->magicItems;
    }

    /**
     * Получить количество предметов
     */
    public function count(): int
    {
        return count($this->magicItems);
    }

    /**
     * Найти предмет по ID
     */
    public function findById(int $id): ?MagicItem
    {
        foreach ($this->magicItems as $magicItem) {
            if ($magicItem->getId() === $id) {
                return $magicItem;
            }
        }

        return null;
    }

    /**
     * Получить предмет по позиции в массиве
     */
    public function get(int $index): ?MagicItem
    {
        return $this->magicItems[$index] ?? null;
    }

    /**
     * Удалить предмет по ID
     */
    public function removeById(int $id): self
    {
        foreach ($this->magicItems as $key => $magicItem) {
            if ($magicItem->getId() === $id) {
                unset($this->magicItems[$key]);
                break;
            }
        }

        $this->magicItems = array_values($this->magicItems);

        return $this;
    }

    /**
     * Очистить коллекцию
     */
    public function clear(): self
    {
        $this->magicItems = [];
        return $this;
    }
}