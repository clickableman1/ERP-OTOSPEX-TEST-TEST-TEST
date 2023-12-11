<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\Order_detailsRepositoryInterface;

class Order_detailsController extends Controller
{
    protected Order_detailsRepositoryInterface $order_detailsRepository;
    protected Request $request;

    public function __construct(Order_detailsRepositoryInterface $order_detailsRepository, Request $request)
    {
        $this->order_detailsRepository = $order_detailsRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->order_detailsRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="order_details.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Order Id','Part Id',
        'Quantity',
        'Unit Price','Subtotal',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['order_id'],$row['part_id'],
        $row['quantity'],
        $row'unit_price'],$row'subtotal'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->order_detailsRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->order_detailsRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->order_detailsRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->order_detailsRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->order_detailsRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->order_detailsRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

