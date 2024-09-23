<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;

class ClientController extends Controller
{
    public function index()
    {
        $menuCatalogues = (new MenuController())->getCataloguesForMenu(); // Gọi phương thức từ MenuController
        $menuCategories = (new MenuController())->getCategoriesForMenu(); // Gọi phương thức từ MenuController
        return view('client.index', compact('menuCatalogues', 'menuCategories'));
    }
}
