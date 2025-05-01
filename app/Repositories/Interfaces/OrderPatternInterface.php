<?php
namespace App\Repositories\Interfaces;

interface OrderPatternInterface
{
    public function filament_table();
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function chart(string $filter);
}
