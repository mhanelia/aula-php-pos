<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryRepository
{
    /**
     * @param Category $categoryModel
     */

    public function __construct(
        protected Category $categoryModel
    ) {

    }
    /**
     * @param int $qtd
     * @return mixed
     */
    public function findPaginate(int $qtd): mixed
    {
        return $this->categoryModel::where('active', 1)->paginate($qtd);

    }
}
