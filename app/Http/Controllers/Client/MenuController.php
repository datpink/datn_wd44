<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;

class MenuController extends Controller
{
    public function getCategoriesForMenu()
    {
        $catalogues = Catalogue::where('status', 'active')->get(); // Lấy danh mục có status là active
        return $this->buildTree($catalogues);
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