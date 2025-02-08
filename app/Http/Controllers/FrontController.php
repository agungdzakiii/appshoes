<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shoe;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    protected $frontService;

    public function __construct(FrontService $frontService) {
        $this->frontService = $frontService;
    }

    public function index() {
        $data = $this->frontService->getFrontPageData();
        return view('front.index', $data);
    }

    public function details(Shoe $shoe){
        return view('front.details', compact('shoe'));
    }

    public function category(Category $category){
        return view('front.category', compact('category'));
    }
}
