<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CategoryService
{

    const IMAGE_PATH = 'images/category';

    public function __construct(
        protected CategoryRepository $categoryRepository
    ){

    }
        /**
         * @param int $qtd
         * @return mixed
         */
        public function findPaginate(int $qtd): mixed
        {
            return $this->categoryRepository->findPaginate($qtd);
        }
}
