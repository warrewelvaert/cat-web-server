<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CatApiController extends Controller
{
    private array $validationRules = [
        'image_url' => 'required|string',
        'lifespan' => 'required|string',
        'detail' => 'required|array',
        'detail.*.name' => 'required|string',
        'detail.*.language' => 'required|string',
        'detail.*.description' => 'required|string',
        'detail.*.origin' => 'required|string',
        'detail.*.temperament' => 'required|string',
        'detail.*.wikipedia_url' => 'required|string'
    ];

    private $_model;
    public function __construct(Cat $model)
    {
        $this->_model = $model;
    }

    public function getAll()
    {
        $entries = $this->_model->with('detail')->get();
        return response()->json($entries);
    }

    public function getAllEnglish()
    {
        $entries = $this->_model->with(['detail' => function ($query) {
            $query->where('language', 'en');
        }])->get();
        return response()->json($entries);
    }

    public function getAllDutch()
    {
        $entries = $this->_model->with(['detail' => function ($query) {
            $query->where('language', 'nl');
        }])->get();
        return response()->json($entries);
    }

    public function get($id)
    {
        $entry = $this->_model->find($id);
        if (!$entry) {
            return response()->json(['message' => 'Entry not found'], Response::HTTP_NOT_FOUND);
        }
        $catsDetails = $entry->detail;
        return [
            'id' => $entry->id,
            'image_url' => $entry->image_url,
            'lifespan' => $entry->lifespan,
            'detail' => $catsDetails,
        ];
    }

    public function getDutch($id)
    {
        $entry = $this->_model->find($id);
        if (!$entry) {
            return response()->json(['message' => 'Entry not found'], Response::HTTP_NOT_FOUND);
        }
        $catsDetails = $entry->detail->where('language', 'nl');
        return [
            'id' => $entry->id,
            'image_url' => $entry->image_url,
            'lifespan' => $entry->lifespan,
            'detail' => $catsDetails[1],
        ];
    }

    public function getEnglish($id)
    {
        $entry = $this->_model->find($id);
        if (!$entry) {
            return response()->json(['message' => 'Entry not found'], Response::HTTP_NOT_FOUND);
        }
        $catsDetails = $entry->detail->where('language', 'en');
        return [
            'id' => $entry->id,
            'image_url' => $entry->image_url,
            'lifespan' => $entry->lifespan,
            'detail' => $catsDetails[0],
        ];
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, $this->validationRules);
        if ($validator->fails()) {
            return response()->json(['message' => 'Request body is invalid'], Response::HTTP_BAD_REQUEST);
        }
        $cat = $this->_model->create([
            'image_url' => $data['image_url'],
            'lifespan' => $data['lifespan'],
        ]);
        $cat->detail()->createMany($data['detail']);
        return response()->json(['message' => 'Cat breed created successfully'], Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    {
        $entry = $this->_model->find($id);
        if (!$entry) {
            return response()->json(['message' => 'Entry not found'], Response::HTTP_NOT_FOUND);
        }
        $data = $request->all();
        $validator = Validator::make($data, $this->validationRules);
        if ($validator->fails()) {
            return response()->json(['message' => 'Request body is invalid'], Response::HTTP_BAD_REQUEST);
        }
        $entry->update([
            'image_url' => $data['image_url'],
            'lifespan' => $data['lifespan'],
        ]);
        $entry->detail()->delete();
        $entry->detail()->createMany($data['detail']);
        return response()->json(['message' => 'Cat breed updated successfully'], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $entry = $this->_model->find($id);
        if (!$entry) {
            return response()->json(['message' => 'Entry not found'], Response::HTTP_NOT_FOUND);
        }
        $entry->detail()->delete();
        $entry->delete();
        return response()->json(['message' => 'Cat deleted successfully'], Response::HTTP_OK);
    }
}
