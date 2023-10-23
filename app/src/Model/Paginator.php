<?php

namespace App\Model;

class Paginator
{
    public int $itemsPerPage = 10;
    public int $items = 0;
    public int $currentPage = 0;
    public int $totalPages;

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function setItemsPerPage($itemsPerPage): static
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }

    public function getItems(): int
    {
        return $this->items;
    }

    public function setItems($items): static
    {
        $this->items = $items;

        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function setCurrentPage($currentPage): static
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function getTotalPages(): int
    {
        return ceil($this->items / $this->itemsPerPage);
    }
}
