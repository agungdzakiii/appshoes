<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerDataRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\ProductTransaction;
use App\Models\Shoe;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    protected $orderService;

    public function __construct(OrderService $orderService ) {
        
        $this->orderService = $orderService;

    }

    public function saveOrder(StoreOrderRequest $request, Shoe $shoe) {
        
        $validated = $request->validated();

        $validated['shoe_id'] = $shoe->id;

        $this->orderService->beginOrder($validated);

        return redirect()->route('front.booking', $shoe->slug);

    }

    public function booking() {
        $data = $this->orderService->getOrderDetails();
        return view ('order.order', $data);
    }

    public function customerData() {
        $data = $this->orderService->getOrderDetails();
        // dd($data);
        return view('order.customer_data', $data);
    }

    public function saveCustomerData(StoreCustomerDataRequest $request) {
        $validated = $request->validated();
        $this->orderService->updateCustomerData($validated);

        return redirect()->route('front.payment');
    }

    public function payment() {
        $data = $this->orderService->getOrderDetails();
        return view ('order.payment', $data);
    }

    public function paymentConfirm(StorePaymentRequest $request) {
        $validated = $request->validated();
        $productTransactionId = $this->orderService->paymentConfirm($validated);

        if ($productTransactionId) {
            return redirect()->route('front.order_finished', $productTransactionId);
        }

        return redirect()->route('front.index')->withErrors(['error' => 'Pembayaran gagal, coba lagi.']);
    }

    public function orderFinished(ProductTransaction $productTransaction) {
        dd($productTransaction);
        return view('order.order_finished', compact('productTransaction'));
    }
}
