<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\Service_ordersRepositoryInterface;

class Service_ordersController extends Controller
{
    protected Service_ordersRepositoryInterface $service_ordersRepository;
    protected Request $request;

    public function __construct(Service_ordersRepositoryInterface $service_ordersRepository, Request $request)
    {
        $this->service_ordersRepository = $service_ordersRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->service_ordersRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="service_orders.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Service Id','User Id','Status',

      'Appointment Date','Order Date',
        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['service_id'],$row['user_id'],$row['status'],

      $row['appointment_date'],$row['order_date'],
        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->service_ordersRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->service_ordersRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->service_ordersRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->service_ordersRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->service_ordersRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->service_ordersRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

