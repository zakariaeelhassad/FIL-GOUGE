<?php

namespace App\Repositories\interface;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function find(int $id);
}
