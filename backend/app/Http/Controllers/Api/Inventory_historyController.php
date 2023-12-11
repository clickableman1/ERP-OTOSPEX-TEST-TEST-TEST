<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\Inventory_historyRepositoryInterface;

class Inventory_historyController extends Controller
{
    protected Inventory_historyRepositoryInterface $inventory_historyRepository;
    protected Request $request;

    public function __construct(Inventory_historyRepositoryInterface $inventory_historyRepository, Request $request)
    {
        $this->inventory_historyRepository = $inventory_historyRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->inventory_historyRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="inventory_history.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Part Id','Transaction Type','Transaction Date','Quantity Change',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['part_id'],$row['transaction_type'],$row['transaction_date'],$row['quantity_change'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->inventory_historyRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->inventory_historyRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->inventory_historyRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->inventory_historyRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->inventory_historyRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->inventory_historyRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

