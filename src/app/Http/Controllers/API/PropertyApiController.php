<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Services\PropertyService;
use Exception;
use Illuminate\Http\Request;

class PropertyApiController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->middleware("permission:property_create", ['only' => 'store']);
        $this->middleware("permission:property_update", ['only' => 'update']);
        $this->middleware("permission:property_delete", ['only' => 'destroy']);

        $this->propertyService = $propertyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $property = $this->propertyService->getByUserId(auth()->user()->id, $request->search, $request->price, $request->sortBy ?? "price", $request->sortOrder ?? "asc");

            return sendResponse(PropertyResource::collection($property));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    public function getExploreProperty(Request $request)
    {
        try {
            $property = $this->propertyService->getAll($request->search, $request->price, $request->sortBy ?? "price", $request->sortOrder ?? "asc");

            return sendResponse(PropertyResource::collection($property));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    public function getDetailProperty($id)
    {
        try {
            $property = $this->propertyService->getById($id);

            if(!$property) return sendError("Property Not Found.");

            return sendResponse(new PropertyResource($property));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only([
            "name",
            "description",
            "kost_type",
            "latitude",
            "longitude",
            "address",
            "price",
            "total_rooms",
            "total_available_rooms"
        ]);

        try {
            $property = $this->propertyService->saveProperty($input);

            return sendResponse(new PropertyResource($property));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $property = $this->propertyService->getById($id);

            if(!$property) return sendError("Property Not Found.");

            $this->authorize("view", $property);

            return sendResponse(new PropertyResource($property));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            "name",
            "description",
            "kost_type",
            "latitude",
            "longitude",
            "address",
            "price",
            "total_rooms",
            "total_available_rooms"
        ]);

        try {
            $property = $this->propertyService->getById($id);

            $this->authorize("update", $property);

            $property = $this->propertyService->updateProperty($data, $id);

            return sendResponse(new PropertyResource($property));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $property = $this->propertyService->getById($id);

            $this->authorize("delete", $property);

            $property = $this->propertyService->deleteById($id);

            return sendResponse(new PropertyResource($property));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }
}
