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

    public function create(array $array)
    {
        return $this->categoryModel::create($array);
    }

    public function delete($id)
    {
        $this->categoryModel::where('id', $id)->update(['active' => 0]);
    }

    public function find($id)
    {

        return $this->categoryModel::where('id', $id)->first();
    }

    public function update(array $array, $id)
    {
        return $this->categoryModel::where('id', $id)->update($array);
    }

    public function search(array $all)
    {
        return $this->categoryModel::where('active', 1)->where('name', 'like', '%' . $all['name'] . '%')->get();
    }

    public function findAll()
    {
        return $this->categoryModel::where('active', 1)->get();
    }


}
