<?php

namespace App\Repositories\Eloquent;

use App\Models\Inventory_history;

use App\Repositories\Inventory_historyRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Inventory_historyRepository extends BaseRepository implements Inventory_historyRepositoryInterface
{
    public function __construct(Inventory_history $model)
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

            if (isset($filter['part_id'])) {
                $query->where('part_id', 'like', '%'.$filter['part_id'].'%');
            }

            if (isset($filter['transaction_type'])) {
                $query->where('transaction_type', 'like', '%'.$filter['transaction_type'].'%');
            }

            if (isset($filter['transaction_date'])) {
                $query->where('transaction_date', 'like', '%'.$filter['transaction_date'].'%');
            }

            if (isset($filter['quantity_change'])) {
                $query->where('quantity_change', 'like', '%'.$filter['quantity_change'].'%');
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
            $inventory_history = Inventory_history::create([
                    'part_id' => $attributes['part_id'] ?? null
,
                    'transaction_type' => $attributes['transaction_type'] ?? null
,
                    'transaction_date' => $attributes['transaction_date'] ?? null
,
                    'quantity_change' => $attributes['quantity_change'] ?? null
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
            $inventory_history = Inventory_history::find($id);
            $inventory_history->update([
                    'part_id' => $attributes['part_id'] ?? null
,
                    'transaction_type' => $attributes['transaction_type'] ?? null
,
                    'transaction_date' => $attributes['transaction_date'] ?? null
,
                    'quantity_change' => $attributes['quantity_change'] ?? null
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

