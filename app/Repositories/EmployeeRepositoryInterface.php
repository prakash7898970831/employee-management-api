<?php

namespace App\Repositories;

interface EmployeeRepositoryInterface
{
    public function getAll($filters);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}