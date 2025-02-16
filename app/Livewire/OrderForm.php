<?php

namespace App\Livewire;

use App\Models\Shoe;
use App\Services\OrderService;
use Livewire\Component;

class OrderForm extends Component
{

    public Shoe $shoe;
    public $orderData;
    public $subTotalAmount;
    public $promoCode = null;
    public $promoCodeId = null;
    public $quantity = 1;
    public $discount = 0;
    public $grandTotalAmount;
    public $totalDiscountAmount = 0;
    public $name;
    public $email;

    protected $orderService;

    public function boot(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function mount(Shoe $shoe, $orderData) {
        $this->shoe = $shoe;
        $this->orderData = $orderData;
        $this->subTotalAmount = $shoe->price;
        $this->grandTotalAmount = $shoe->price;
    }

    public function updatedQuantity() {
        $this->validateOnly('quantity', [
            'quantity' => 'required|integer|min:1|max:' . $this->shoe->stock,
        ],
        [
            'quantity.max' => 'Stock tidak tersedia!',
        ]);

        $this->calculateTotal();
    }

    protected function calculateTotal(): void {
       $this->subTotalAmount = $this->shoe->price * $this->quantity;
       $this->grandTotalAmount = $this->subTotalAmount - $this->discount;
    }

    public function incrementQuantity() {
        if ($this->quantity < $this->shoe->stock) {
            $this->quantity++;
            $this->calculateTotal();
        }
    }

    public function decrementQuantity() {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->calculateTotal();
        }
    }

    public function render()
    {
        return view('livewire.order-form');
    }
}
