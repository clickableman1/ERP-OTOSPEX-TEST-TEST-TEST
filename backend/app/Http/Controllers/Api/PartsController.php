<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\PartsRepositoryInterface;

class PartsController extends Controller
{
    protected PartsRepositoryInterface $partsRepository;
    protected Request $request;

    public function __construct(PartsRepositoryInterface $partsRepository, Request $request)
    {
        $this->partsRepository = $partsRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->partsRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="parts.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Name','Description','Barcode','Category','Dimensions','Manufacturer Id','Supplier Id',
        'Quantity In Stock','Minimum Stock Level',
        'Price','Weight',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['name'],$row['description'],$row['barcode'],$row['category'],$row['dimensions'],$row['manufacturer_id'],$row['supplier_id'],
        $row['quantity_in_stock'],$row['minimum_stock_level'],
        $row'price'],$row'weight'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->partsRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->partsRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->partsRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->partsRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->partsRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->partsRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

