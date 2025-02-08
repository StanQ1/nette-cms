<?php

namespace App\Services;

use App\Core\BaseModel;
use Nette\Database\Table\ActiveRow;

class CategoryService extends BaseModel
{
    private string $table = 'article_categories';

    public function getAllCategories(): array
    {
        return $this->database->table($this->table)->fetchAll();
    }

    public function getCategoryById(int $id): ActiveRow
    {
        return $this->database->table($this->table)->get($id);
    }

    public function getCategoryByName(string $categoryName): ActiveRow
    {
        return $this->database->table($this->table)->where('category_name', $categoryName);
    }

    public function createCategory(string $categoryName): bool
    {
        // TODO: [Hot Fix] fixed category_id incrementing
        $lastCategory = $this->database->table($this->table)->max('category_id');

        try {
            $this->database->table($this->table)->insert([
                'category_name' => $categoryName,
                'category_id' => $lastCategory + 1,
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function editCategory(int $id, string $categoryName): bool
    {
        try {
            $this->database->table($this->table)->where('id', $id)->update([
                'category_name' => $categoryName,
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteCategory(int $id): bool
    {
        try {
            $this->database->table($this->table)->get($id)->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}