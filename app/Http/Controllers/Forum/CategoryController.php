<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Services\Forum\CategoryService;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $_categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->_categoryService = $categoryService;
    }

    /**
     * show a single category based on its slug alongside
     * all its topics
     */
    public function showSingleCategory($slug)
    {
        return $this->_categoryService->singleCategory($slug);
    }
}
