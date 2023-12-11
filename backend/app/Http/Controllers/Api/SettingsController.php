<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\SettingsRepositoryInterface;

class SettingsController extends Controller
{
    protected SettingsRepositoryInterface $settingsRepository;
    protected Request $request;

    public function __construct(SettingsRepositoryInterface $settingsRepository, Request $request)
    {
        $this->settingsRepository = $settingsRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->settingsRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="settings.csv"');
            $rows = $payload['rows'];
            $fields = array('id','User Id','Language Id','Currency',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['user_id'],$row['language_id'],$row['currency'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->settingsRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->settingsRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->settingsRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->settingsRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->settingsRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->settingsRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

