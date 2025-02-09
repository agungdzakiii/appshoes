<?php 

namespace App\Repositories\Contracts;

interface ShoeRepositoryInterface {
    public function getPopularShoes($limit);

    public function getAllNewShoes();

    public function searchByName(string $keyword);

    public function find($id);

    public function getPrice($ticketId);
}