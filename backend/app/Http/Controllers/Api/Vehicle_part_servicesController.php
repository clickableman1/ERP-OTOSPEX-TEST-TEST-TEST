<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\Vehicle_part_servicesRepositoryInterface;

class Vehicle_part_servicesController extends Controller
{
    protected Vehicle_part_servicesRepositoryInterface $vehicle_part_servicesRepository;
    protected Request $request;

    public function __construct(Vehicle_part_servicesRepositoryInterface $vehicle_part_servicesRepository, Request $request)
    {
        $this->vehicle_part_servicesRepository = $vehicle_part_servicesRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->vehicle_part_servicesRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="vehicle_part_services.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Service Id','Part Id',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['service_id'],$row['part_id'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->vehicle_part_servicesRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->vehicle_part_servicesRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->vehicle_part_servicesRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->vehicle_part_servicesRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->vehicle_part_servicesRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->vehicle_part_servicesRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

