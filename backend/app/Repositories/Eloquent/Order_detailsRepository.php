<?php

namespace App\Repositories\Eloquent;

use App\Models\Order_details;

use App\Repositories\Order_detailsRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Order_detailsRepository extends BaseRepository implements Order_detailsRepositoryInterface
{
    public function __construct(Order_details $model)
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

            if (isset($filter['order_id'])) {
                $query->where('order_id', 'like', '%'.$filter['order_id'].'%');
            }

            if (isset($filter['part_id'])) {
                $query->where('part_id', 'like', '%'.$filter['part_id'].'%');
            }

            if (isset($filter['quantityRange'])) {
                [$start, $end] = $filter['quantityRange'];

                if (!empty($start)) {
                    $query->where('quantity', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('quantity', '<=', $end);
                }
            }

            if (isset($filter['unit_priceRange'])) {
                [$start, $end] = $filter['unit_priceRange'];

                if (!empty($start)) {
                    $query->where('unit_price', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('unit_price', '<=', $end);
                }
            }

            if (isset($filter['subtotalRange'])) {
                [$start, $end] = $filter['subtotalRange'];

                if (!empty($start)) {
                    $query->where('subtotal', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('subtotal', '<=', $end);
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
            $order_details = Order_details::create([
                    'order_id' => $attributes['order_id'] ?? null
,
                    'part_id' => $attributes['part_id'] ?? null
,
                    'quantity' => $attributes['quantity'] ?? null
,
                    'unit_price' => $attributes['unit_price'] ?? null
,
                    'subtotal' => $attributes['subtotal'] ?? null
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
            $order_details = Order_details::find($id);
            $order_details->update([
                    'order_id' => $attributes['order_id'] ?? null
,
                    'part_id' => $attributes['part_id'] ?? null
,
                    'quantity' => $attributes['quantity'] ?? null
,
                    'unit_price' => $attributes['unit_price'] ?? null
,
                    'subtotal' => $attributes['subtotal'] ?? null
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

