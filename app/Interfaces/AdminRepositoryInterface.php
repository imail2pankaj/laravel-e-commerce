<?php

namespace App\Interfaces;

interface AdminRepositoryInterface
{
    public function all();
    public function allQuery();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
