<?php 

use App\Models\PromoCode;


class PromoCodeRepository implements PromoCodeRepositoryInterface {
    public function getAllPromoCode() {
        return PromoCode::latest()->get();
    }

    public function findByCode(string $code) {
        return PromoCode::where("code", $code)->first();
    }
}