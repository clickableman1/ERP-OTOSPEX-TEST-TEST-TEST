<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\Cart_itemsRepositoryInterface;

class Cart_itemsController extends Controller
{
    protected Cart_itemsRepositoryInterface $cart_itemsRepository;
    protected Request $request;

    public function __construct(Cart_itemsRepositoryInterface $cart_itemsRepository, Request $request)
    {
        $this->cart_itemsRepository = $cart_itemsRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->cart_itemsRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="cart_items.csv"');
            $rows = $payload['rows'];
            $fields = array('id',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->cart_itemsRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->cart_itemsRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->cart_itemsRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->cart_itemsRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->cart_itemsRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->cart_itemsRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

