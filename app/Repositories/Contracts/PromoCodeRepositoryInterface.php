<?php

use App\Repositories\Contracts;

interface PromoCodeRepositoryInterface {
    public function getAllPromoCode();

    public function findByCode(string $code);
}