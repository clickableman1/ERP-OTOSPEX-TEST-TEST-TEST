<?php

namespace App\Repositories\Eloquent;

use App\Models\Suppliers;

use App\Repositories\SuppliersRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SuppliersRepository extends BaseRepository implements SuppliersRepositoryInterface
{
    public function __construct(Suppliers $model)
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

            if (isset($filter['location'])) {
                $query->where('location', 'like', '%'.$filter['location'].'%');
            }

            if (isset($filter['email'])) {
                $query->where('email', 'like', '%'.$filter['email'].'%');
            }

            if (isset($filter['country_of_origin'])) {
                $query->where('country_of_origin', 'like', '%'.$filter['country_of_origin'].'%');
            }

            if (isset($filter['phone'])) {
                $query->where('phone', 'like', '%'.$filter['phone'].'%');
            }

            if (isset($filter['website'])) {
                $query->where('website', 'like', '%'.$filter['website'].'%');
            }

            if (isset($filter['year_establishedRange'])) {
                [$start, $end] = $filter['year_establishedRange'];

                if (!empty($start)) {
                    $query->where('year_established', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('year_established', '<=', $end);
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
            $suppliers = Suppliers::create([
                    'name' => $attributes['name'] ?? null
,
                    'location' => $attributes['location'] ?? null
,
                    'email' => $attributes['email'] ?? null
,
                    'country_of_origin' => $attributes['country_of_origin'] ?? null
,
                    'phone' => $attributes['phone'] ?? null
,
                    'year_established' => $attributes['year_established'] ?? null
,
                    'website' => $attributes['website'] ?? null
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
            $suppliers = Suppliers::find($id);
            $suppliers->update([
                    'name' => $attributes['name'] ?? null
,
                    'location' => $attributes['location'] ?? null
,
                    'email' => $attributes['email'] ?? null
,
                    'country_of_origin' => $attributes['country_of_origin'] ?? null
,
                    'phone' => $attributes['phone'] ?? null
,
                    'year_established' => $attributes['year_established'] ?? null
,
                    'website' => $attributes['website'] ?? null
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

