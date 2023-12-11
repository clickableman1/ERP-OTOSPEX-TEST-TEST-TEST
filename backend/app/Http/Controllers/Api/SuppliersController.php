<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\SuppliersRepositoryInterface;

class SuppliersController extends Controller
{
    protected SuppliersRepositoryInterface $suppliersRepository;
    protected Request $request;

    public function __construct(SuppliersRepositoryInterface $suppliersRepository, Request $request)
    {
        $this->suppliersRepository = $suppliersRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->suppliersRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="suppliers.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Name','Location','Email','Country Of Origin','Phone','Website',
        'Year Established',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['name'],$row['location'],$row['email'],$row['country_of_origin'],$row['phone'],$row['website'],
        $row['year_established'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->suppliersRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->suppliersRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->suppliersRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->suppliersRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->suppliersRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->suppliersRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

