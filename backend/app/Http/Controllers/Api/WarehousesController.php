<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\WarehousesRepositoryInterface;

class WarehousesController extends Controller
{
    protected WarehousesRepositoryInterface $warehousesRepository;
    protected Request $request;

    public function __construct(WarehousesRepositoryInterface $warehousesRepository, Request $request)
    {
        $this->warehousesRepository = $warehousesRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->warehousesRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="warehouses.csv"');
            $rows = $payload['rows'];
            $fields = array('id',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->warehousesRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->warehousesRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->warehousesRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->warehousesRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->warehousesRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->warehousesRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

