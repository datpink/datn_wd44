<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $title = '';

        $catalogueCount = Catalogue::count();
        $orderCount = Order::count();

        return view('admin.index', compact('title', 'catalogueCount', 'orderCount'));
    }
}
