<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Category;

class MenuController extends Controller
{
    public function getCataloguesForMenu()
    {
        $catalogues = Catalogue::where('status', 'active')->get(); // Lấy danh mục có status là active
        return $this->buildTree($catalogues);
    }

    public function getCategoriesForMenu()
    {
        $categories = Category::where('status', 'active')->get(); // Lấy danh mục có status là active
        return $this->buildTree($categories);
    }

    private function buildTree($elements, $parentId = 0)
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }
}