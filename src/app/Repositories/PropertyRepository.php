<?php

namespace App\Repositories;

use App\Models\Property;
use InvalidArgumentException;

class PropertyRepository
{
    protected $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    public function getAll($location, $price, $sortBy, $sortOrder)
    {
        if(!in_array($sortBy, $this->property->getFillable())) {
            throw new InvalidArgumentException("$sortBy not exists");
        }

        return $this->property
            ->when(!empty($location), function($query) use ($location) {
                $query->where('name', 'LIKE', '%' . $location . '%')
                    ->orWhere('address', 'LIKE', '%' . $location . '%');
            })
            ->when(!empty($price), function($query) use ($price) {
                $price = explode("-", $price);

                if(is_array($price) && count($price) > 1) {
                    $query->whereBetween("price", [(int) $price[0], (int) $price[1]]);
                }
            })
            ->orderBy($sortBy, $sortOrder)
            ->get();
    }

    public function getByUserId($userId, $location, $price, $sortBy, $sortOrder)
    {
        if(!in_array($sortBy, $this->property->getFillable())) {
            throw new InvalidArgumentException("$sortBy not exists");
        }

        return $this->property->where('user_id', $userId)
            ->when(!empty($location), function($query) use ($location) {
                $query->where('name', 'LIKE', '%' . $location . '%')
                    ->orWhere('address', 'LIKE', '%' . $location . '%');
            })
            ->when(!empty($price), function($query) use ($price) {
                $price = explode("-", $price);

                if(is_array($price) && count($price) > 1) {
                    $query->whereBetween("price", [(int) $price[0], (int) $price[1]]);
                }
            })
            ->orderBy($sortBy, $sortOrder)
            ->get();
    }

    public function getById($id)
    {
        return $this->property->where('id', $id)->first();
    }

    public function save($data)
    {
        $property = new $this->property;

        $property->user_id = $data['user_id'];
        $property->name = $data['name'];
        $property->description = $data['description'];
        $property->kost_type = $data['kost_type'];
        $property->latitude = $data['latitude'];
        $property->longitude = $data['longitude'];
        $property->address = $data['address'];
        $property->price = $data['price'];
        $property->total_rooms = $data['total_rooms'];
        $property->total_available_rooms = $data['total_available_rooms'];

        $property->save();

        return $property->fresh();
    }

    public function update($data, $id)
    {
        $property = $this->property->find($id);

        $property->name = $data['name'];
        $property->description = $data['description'];
        $property->kost_type = $data['kost_type'];
        $property->latitude = $data['latitude'];
        $property->longitude = $data['longitude'];
        $property->address = $data['address'];
        $property->price = $data['price'];
        $property->total_rooms = $data['total_rooms'];
        $property->total_available_rooms = $data['total_available_rooms'];

        $property->update();

        return $property->fresh();
    }

    public function delete($id)
    {
        $property = $this->property->find($id);
        $property->delete();

        return $property;
    }
}
