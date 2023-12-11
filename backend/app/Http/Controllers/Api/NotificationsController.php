<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\NotificationsRepositoryInterface;

class NotificationsController extends Controller
{
    protected NotificationsRepositoryInterface $notificationsRepository;
    protected Request $request;

    public function __construct(NotificationsRepositoryInterface $notificationsRepository, Request $request)
    {
        $this->notificationsRepository = $notificationsRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->notificationsRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="notifications.csv"');
            $rows = $payload['rows'];
            $fields = array('id','User Id','Content','Status',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['user_id'],$row['content'],$row['status'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->notificationsRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->notificationsRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->notificationsRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->notificationsRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->notificationsRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->notificationsRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

