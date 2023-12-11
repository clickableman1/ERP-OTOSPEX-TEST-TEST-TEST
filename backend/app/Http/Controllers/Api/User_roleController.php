<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\User_roleRepositoryInterface;

class User_roleController extends Controller
{
    protected User_roleRepositoryInterface $user_roleRepository;
    protected Request $request;

    public function __construct(User_roleRepositoryInterface $user_roleRepository, Request $request)
    {
        $this->user_roleRepository = $user_roleRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->user_roleRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="user_role.csv"');
            $rows = $payload['rows'];
            $fields = array('id','User Id','Role Id',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['user_id'],$row['role_id'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->user_roleRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->user_roleRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->user_roleRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->user_roleRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->user_roleRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->user_roleRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

