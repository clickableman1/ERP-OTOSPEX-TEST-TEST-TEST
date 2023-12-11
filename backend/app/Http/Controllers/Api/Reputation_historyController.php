<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\Reputation_historyRepositoryInterface;

class Reputation_historyController extends Controller
{
    protected Reputation_historyRepositoryInterface $reputation_historyRepository;
    protected Request $request;

    public function __construct(Reputation_historyRepositoryInterface $reputation_historyRepository, Request $request)
    {
        $this->reputation_historyRepository = $reputation_historyRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->reputation_historyRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="reputation_history.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Action','Reputation Change',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['action'],$row['reputation_change'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->reputation_historyRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->reputation_historyRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->reputation_historyRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->reputation_historyRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->reputation_historyRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->reputation_historyRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

