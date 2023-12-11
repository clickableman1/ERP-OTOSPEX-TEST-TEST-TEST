<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\Purchase_ordersRepositoryInterface;

class Purchase_ordersController extends Controller
{
    protected Purchase_ordersRepositoryInterface $purchase_ordersRepository;
    protected Request $request;

    public function __construct(Purchase_ordersRepositoryInterface $purchase_ordersRepository, Request $request)
    {
        $this->purchase_ordersRepository = $purchase_ordersRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->purchase_ordersRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="purchase_orders.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Order Id','Supplier Id','Invoice Id',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['order_id'],$row['supplier_id'],$row['invoice_id'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->purchase_ordersRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->purchase_ordersRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->purchase_ordersRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->purchase_ordersRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->purchase_ordersRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->purchase_ordersRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

