<?php

namespace App\Repositories\Eloquent;

use App\Models\Parts;

use App\Repositories\PartsRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PartsRepository extends BaseRepository implements PartsRepositoryInterface
{
    public function __construct(Parts $model)
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

            if (isset($filter['name'])) {
                $query->where('name', 'like', '%'.$filter['name'].'%');
            }

            if (isset($filter['description'])) {
                $query->where('description', 'like', '%'.$filter['description'].'%');
            }

            if (isset($filter['barcode'])) {
                $query->where('barcode', 'like', '%'.$filter['barcode'].'%');
            }

            if (isset($filter['category'])) {
                $query->where('category', 'like', '%'.$filter['category'].'%');
            }

            if (isset($filter['dimensions'])) {
                $query->where('dimensions', 'like', '%'.$filter['dimensions'].'%');
            }

            if (isset($filter['manufacturer_id'])) {
                $query->where('manufacturer_id', 'like', '%'.$filter['manufacturer_id'].'%');
            }

            if (isset($filter['supplier_id'])) {
                $query->where('supplier_id', 'like', '%'.$filter['supplier_id'].'%');
            }

            if (isset($filter['priceRange'])) {
                [$start, $end] = $filter['priceRange'];

                if (!empty($start)) {
                    $query->where('price', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('price', '<=', $end);
                }
            }

            if (isset($filter['weightRange'])) {
                [$start, $end] = $filter['weightRange'];

                if (!empty($start)) {
                    $query->where('weight', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('weight', '<=', $end);
                }
            }

            if (isset($filter['quantity_in_stockRange'])) {
                [$start, $end] = $filter['quantity_in_stockRange'];

                if (!empty($start)) {
                    $query->where('quantity_in_stock', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('quantity_in_stock', '<=', $end);
                }
            }

            if (isset($filter['minimum_stock_levelRange'])) {
                [$start, $end] = $filter['minimum_stock_levelRange'];

                if (!empty($start)) {
                    $query->where('minimum_stock_level', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('minimum_stock_level', '<=', $end);
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
            $parts = Parts::create([
                    'name' => $attributes['name'] ?? null
,
                    'description' => $attributes['description'] ?? null
,
                    'barcode' => $attributes['barcode'] ?? null
,
                    'category' => $attributes['category'] ?? null
,
                    'price' => $attributes['price'] ?? null
,
                    'weight' => $attributes['weight'] ?? null
,
                    'dimensions' => $attributes['dimensions'] ?? null
,
                    'quantity_in_stock' => $attributes['quantity_in_stock'] ?? null
,
                    'minimum_stock_level' => $attributes['minimum_stock_level'] ?? null
,
                    'manufacturer_id' => $attributes['manufacturer_id'] ?? null
,
                    'supplier_id' => $attributes['supplier_id'] ?? null
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
            $parts = Parts::find($id);
            $parts->update([
                    'name' => $attributes['name'] ?? null
,
                    'description' => $attributes['description'] ?? null
,
                    'barcode' => $attributes['barcode'] ?? null
,
                    'category' => $attributes['category'] ?? null
,
                    'price' => $attributes['price'] ?? null
,
                    'weight' => $attributes['weight'] ?? null
,
                    'dimensions' => $attributes['dimensions'] ?? null
,
                    'quantity_in_stock' => $attributes['quantity_in_stock'] ?? null
,
                    'minimum_stock_level' => $attributes['minimum_stock_level'] ?? null
,
                    'manufacturer_id' => $attributes['manufacturer_id'] ?? null
,
                    'supplier_id' => $attributes['supplier_id'] ?? null
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

