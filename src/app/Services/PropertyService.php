<?php

namespace App\Services;

use App\Repositories\PropertyRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class PropertyService
{
    public $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function getAll($location = "", $price = "", $sortBy = "price", $sortOrder = "asc")
    {
        return $this->propertyRepository->getAll($location, $price, $sortBy, $sortOrder);
    }

    public function getByUserId($userId, $location = "", $price = "", $sortBy = "price", $sortOrder = "asc")
    {
        return $this->propertyRepository->getByUserId($userId, $location, $price, $sortBy, $sortOrder);
    }

    public function getById($id)
    {
        return $this->propertyRepository->getById($id);
    }

    public function saveProperty($data)
    {
        $validator = validator($data, [
            "name" => "required",
            "description" => "required",
            "kost_type" => "required|in:0,1,2",
            "latitude" => "required",
            "longitude" => "required",
            "address" => "required",
            "price" => "required",
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data["user_id"] = auth()->user()->id;
        $result = $this->propertyRepository->save($data);

        return $result;
    }

    public function updateProperty($data, $id)
    {
        $validator = validator($data, [
            "name" => "required",
            "description" => "required",
            "kost_type" => "required|in:0,1,2",
            "latitude" => "required",
            "longitude" => "required",
            "address" => "required",
            "price" => "required",
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $property = $this->propertyRepository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update property data');
        }

        DB::commit();

        return $property;
    }

    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            $property = $this->propertyRepository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete property data');
        }

        DB::commit();

        return $property;
    }

}
