<?php

namespace App\Services;

use App\Models\Category;
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

    public function create(array $data): ?Model
    {
        $image = Arr::get($data, 'image');
        $fileName = FileService::move($image, self::IMAGE_PATH);
        return $this->categoryRepository->create([
            'name' => Arr::get($data, 'name'),
            'image' => $fileName
        ]);

    }

    public function delete($id)
    {
        $this->categoryRepository->delete($id);
    }

    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function update(array $data, $id)
    {
        $name = [
            'name' => Arr::get($data, 'name'),
        ];

        if (!empty($data['image'])) {
            $deletedImage = Arr::get($data, 'deleted_image');
            FileService::delete($deletedImage, self::IMAGE_PATH);
            $fileName = FileService::move($data['image'], self::IMAGE_PATH);
            $name['image'] = $fileName;
        }

        return $this->categoryRepository->update($name, $id);
    }

    public function search(array $all)
    {
        return $this->categoryRepository->search($all);
    }

    public function findAll()
    {
        return $this->categoryRepository->findAll();
    }
}
