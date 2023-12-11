<?php

namespace App\Repositories\Eloquent;

use App\Models\Invoices;

use App\Repositories\InvoicesRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InvoicesRepository extends BaseRepository implements InvoicesRepositoryInterface
{
    public function __construct(Invoices $model)
    {
        parent::__construct($model);
    }

    public function findAll($params) : array
    {
        $limit = 0;
        $offset = 0;
        $orderBy = null;

        $query = $this->model->newModelQuery();
        //$query->select("*", "product as prod_id");

        if (isset($params['filter'])) {
            $filter = $params['filter'];

            if (isset($filter['issue_date'])) {
                $query->where('issue_date', 'like', '%'.$filter['issue_date'].'%');
            }

            if (isset($filter['due_date'])) {
                $query->where('due_date', 'like', '%'.$filter['due_date'].'%');
            }

            if (isset($filter['user_id'])) {
                $query->where('user_id', 'like', '%'.$filter['user_id'].'%');
            }

            if (isset($filter['supplier_id'])) {
                $query->where('supplier_id', 'like', '%'.$filter['supplier_id'].'%');
            }

            if (isset($filter['invoice_numberRange'])) {
                [$start, $end] = $filter['invoice_numberRange'];

                if (!empty($start)) {
                    $query->where('invoice_number', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('invoice_number', '<=', $end);
                }
            }

            if (isset($filter['total_amountRange'])) {
                [$start, $end] = $filter['total_amountRange'];

                if (!empty($start)) {
                    $query->where('total_amount', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('total_amount', '<=', $end);
                }
            }

            if (isset($filter['active'])) {
                $query->where('active', $params['active']);
            }

            if (isset($filter['createdAtRange'])) {
                [$start, $end] = $filter['createdAtRange'];

                if (!empty($start)) {
                    $query->where('created_at', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('created_at', '<=', $end);
                }
            }
        }

        if ($limit) {
            $query->limit($limit);
        }

        $rows = $query->get();

        return [
            'rows' => $rows->toArray(),
            'count' => $rows->count(),
        ];
    }

    public function create(array $attributes, $currentUser)
    {
        try {
            $attributes = $attributes['data'];
            DB::beginTransaction();
            $attributes['created_by_user'] = $currentUser->id;
            $invoices = Invoices::create([
                    'invoice_number' => $attributes['invoice_number'] ?? null
,
                    'issue_date' => $attributes['issue_date'] ?? null
,
                    'due_date' => $attributes['due_date'] ?? null
,
                    'user_id' => $attributes['user_id'] ?? null
,
                    'supplier_id' => $attributes['supplier_id'] ?? null
,
                    'total_amount' => $attributes['total_amount'] ?? null
,
                    'created_by_user' => $currentUser->id
                ]);

            DB::commit();

            return [];
        } catch (Exception $exception) {
            DB::rollback();
        }
    }

    public function update($id, array $attributes, $currentUser)
    {
        try {
            $attributes = $attributes['data'];
            DB::beginTransaction();
            $invoices = Invoices::find($id);
            $invoices->update([
                    'invoice_number' => $attributes['invoice_number'] ?? null
,
                    'issue_date' => $attributes['issue_date'] ?? null
,
                    'due_date' => $attributes['due_date'] ?? null
,
                    'user_id' => $attributes['user_id'] ?? null
,
                    'supplier_id' => $attributes['supplier_id'] ?? null
,
                    'total_amount' => $attributes['total_amount'] ?? null
,
                    'updated_by_user' => $currentUser->id
                ]);

            DB::commit();

            return [];
        } catch (Exception $exception) {
            DB::rollback();
        }
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    public function findById($id)
    {
        $query = $this->model->newModelQuery();

        $query
            ->where('id', $id);

        return $query->get()[0];
    }

    public function findAllAutocomplete(array $params)
    {
        $query = $this->model->newModelQuery();

        $query->select('*', 'id as label');

        if (isset($params['query'])) {
            $query->where('id', 'like', '%'.$params['query'].'%');
        }

        if (isset($params['limit'])) {
            $query->limit($params['limit']);
        }

        $query->orderBy('id', 'ASC');

        return $query->get()
            ->map(fn($item) => ['id' => $item->id, 'label' => $item->label]);
    }
}

