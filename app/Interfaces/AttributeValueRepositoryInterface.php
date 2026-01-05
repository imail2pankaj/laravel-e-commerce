<?php

namespace App\Interfaces;


interface AttributeValueRepositoryInterface
{
    public function all();
    public function allQuery();
    public function find($id);

    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    public function getMaxSortOrder(int $attributeId): int;

    public function getActiveAttributes();
    public function getActiveAttributesWithValues();

}
