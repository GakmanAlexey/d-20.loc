<?php

namespace Modules\Systv\Modul\Entity;

class Myth
{
    private int $id = 0;
    private ?int $era_id = null;

    private string $title = '';
    private string $slug = '';

    private int $order_num = 0;

    private string $short_text = '';
    private string $content = '';

    private string $status = 'draft';

    private ?string $created_at = null;
    private ?string $updated_at = null;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Myth
    {
        $this->id = $id;
        return $this;
    }


    public function getEraId(): ?int
    {
        return $this->era_id;
    }

    public function setEraId(?int $era_id): Myth
    {
        $this->era_id = $era_id;
        return $this;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Myth
    {
        $this->title = $title;
        return $this;
    }


    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): Myth
    {
        $this->slug = $slug;
        return $this;
    }


    public function getOrderNum(): int
    {
        return $this->order_num;
    }

    public function setOrderNum(int $order_num): Myth
    {
        $this->order_num = $order_num;
        return $this;
    }


    public function getShortText(): string
    {
        return $this->short_text;
    }

    public function setShortText(string $short_text): Myth
    {
        $this->short_text = $short_text;
        return $this;
    }


    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Myth
    {
        $this->content = $content;
        return $this;
    }


    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): Myth
    {
        $this->status = $status;
        return $this;
    }


    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(?string $created_at): Myth
    {
        $this->created_at = $created_at;
        return $this;
    }


    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?string $updated_at): Myth
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}