<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\InvoicesRepositoryInterface;

class InvoicesController extends Controller
{
    protected InvoicesRepositoryInterface $invoicesRepository;
    protected Request $request;

    public function __construct(InvoicesRepositoryInterface $invoicesRepository, Request $request)
    {
        $this->invoicesRepository = $invoicesRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->invoicesRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="invoices.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Issue Date','Due Date','User Id','Supplier Id',

        'Invoice Number','Total Amount',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['issue_date'],$row['due_date'],$row['user_id'],$row['supplier_id'],

        $row'invoice_number'],$row'total_amount'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->invoicesRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->invoicesRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->invoicesRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->invoicesRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->invoicesRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->invoicesRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

