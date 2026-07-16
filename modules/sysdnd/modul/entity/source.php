<?php

namespace Modules\Sysdnd\Modul\Entity;

class Source
{
    private $id;
    private $nameRu;
    private $name;
    private $slug;
    private $microLabel;
    private $description;
    private $status;
    private $idIMG;
    private $datePublisher;
    private $studio;
    private $dateCreate;
    private $dateUpdate;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNameRu()
    {
        return $this->nameRu;
    }

    public function setNameRu($nameRu): self
    {
        $this->nameRu = $nameRu;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): self
    {
        $this->slog = $slug;
        return $this;
    }

    public function getMicroLabel()
    {
        return $this->microLabel;
    }

    public function setMicroLabel($microLabel): self
    {
        $this->microLabel = $microLabel;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getIdIMG()
    {
        return $this->idIMG;
    }

    public function setIdIMG($idIMG): self
    {
        $this->idIMG = $idIMG;
        return $this;
    }

    public function getDatePublisher()
    {
        return $this->datePublisher;
    }

    public function setDatePublisher($datePublisher): self
    {
        $this->datePublisher = $datePublisher;
        return $this;
    }

    public function getStudio()
    {
        return $this->studio;
    }

    public function setStudio($studio): self
    {
        $this->studio = $studio;
        return $this;
    }

    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    public function setDateCreate($dateCreate): self
    {
        $this->dateCreate = $dateCreate;
        return $this;
    }

    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate($dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;
        return $this;
    }
}