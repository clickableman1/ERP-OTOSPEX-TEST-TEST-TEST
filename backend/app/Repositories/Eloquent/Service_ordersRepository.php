<?php

namespace App\Repositories\Eloquent;

use App\Models\Service_orders;

use App\Repositories\Service_ordersRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Service_ordersRepository extends BaseRepository implements Service_ordersRepositoryInterface
{
    public function __construct(Service_orders $model)
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

            if (isset($filter['service_id'])) {
                $query->where('service_id', 'like', '%'.$filter['service_id'].'%');
            }

            if (isset($filter['user_id'])) {
                $query->where('user_id', 'like', '%'.$filter['user_id'].'%');
            }

            if (isset($filter['status'])) {
                $query->where('status', 'like', '%'.$filter['status'].'%');
            }

            if (isset($filter['appointment_dateRange'])) {
                [$start, $end] = $filter['appointment_dateRange'];

                if (!empty($start)) {
                    $query->where('appointment_date', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('appointment_date', '<=', $end);
                }
            }

            if (isset($filter['order_dateRange'])) {
                [$start, $end] = $filter['order_dateRange'];

                if (!empty($start)) {
                    $query->where('order_date', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('order_date', '<=', $end);
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
            $service_orders = Service_orders::create([
                    'service_id' => $attributes['service_id'] ?? null
,
                    'user_id' => $attributes['user_id'] ?? null
,
                    'status' => $attributes['status'] ?? null
,
                    'appointment_date' => $attributes['appointment_date'] ?? null
,
                    'order_date' => $attributes['order_date'] ?? null
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
            $service_orders = Service_orders::find($id);
            $service_orders->update([
                    'service_id' => $attributes['service_id'] ?? null
,
                    'user_id' => $attributes['user_id'] ?? null
,
                    'status' => $attributes['status'] ?? null
,
                    'appointment_date' => $attributes['appointment_date'] ?? null
,
                    'order_date' => $attributes['order_date'] ?? null
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

