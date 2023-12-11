<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\Sale_ordersRepositoryInterface;

class Sale_ordersController extends Controller
{
    protected Sale_ordersRepositoryInterface $sale_ordersRepository;
    protected Request $request;

    public function __construct(Sale_ordersRepositoryInterface $sale_ordersRepository, Request $request)
    {
        $this->sale_ordersRepository = $sale_ordersRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->sale_ordersRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="sale_orders.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Order Id','Invoice Id',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['order_id'],$row['invoice_id'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->sale_ordersRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->sale_ordersRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->sale_ordersRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->sale_ordersRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->sale_ordersRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->sale_ordersRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

