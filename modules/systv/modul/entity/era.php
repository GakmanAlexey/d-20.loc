<?php

namespace Modules\Systv\Modul\Entity;

class Era
{
    private int $id = 0;
    private string $name = '';
    private int $start_year = 0;
    private int $end_year = 0;
    private string $description = '';
    private ?string $created_at = null;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Era
    {
        $this->id = $id;
        return $this;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Era
    {
        $this->name = $name;
        return $this;
    }


    public function getStartYear(): int
    {
        return $this->start_year;
    }

    public function setStartYear(int $start_year): Era
    {
        $this->start_year = $start_year;
        return $this;
    }


    public function getEndYear(): int
    {
        return $this->end_year;
    }

    public function setEndYear(int $end_year): Era
    {
        $this->end_year = $end_year;
        return $this;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Era
    {
        $this->description = $description;
        return $this;
    }


    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(?string $created_at): Era
    {
        $this->created_at = $created_at;
        return $this;
    }
}