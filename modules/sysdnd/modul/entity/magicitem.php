<?php

namespace Modules\Sysdnd\Modul\Entity;

class Magicitem
{
    private $id;
    private $nameRu;
    private $name;
    private $source;
    private $type;
    private $rarity;
    private $attunement;
    private $attunementSpecial;
    private $costFrom;
    private $costTo;
    private $idIMG;
    private $description;
    private $status;
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

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source): self
    {
        $this->source = $source;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getRarity()
    {
        return $this->rarity;
    }

    public function setRarity($rarity): self
    {
        $this->rarity = $rarity;
        return $this;
    }

    public function getAttunement()
    {
        return $this->attunement;
    }

    public function setAttunement($attunement): self
    {
        $this->attunement = $attunement;
        return $this;
    }

    public function getAttunementSpecial()
    {
        return $this->attunementSpecial;
    }

    public function setAttunementSpecial($attunementSpecial): self
    {
        $this->attunementSpecial = $attunementSpecial;
        return $this;
    }

    public function getCostFrom()
    {
        return $this->costFrom;
    }

    public function setCostFrom($costFrom): self
    {
        $this->costFrom = $costFrom;
        return $this;
    }

    public function getCostTo()
    {
        return $this->costTo;
    }

    public function setCostTo($costTo): self
    {
        $this->costTo = $costTo;
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