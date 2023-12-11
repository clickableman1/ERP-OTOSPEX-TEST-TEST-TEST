<?php

namespace App\Repositories\Eloquent;

use App\Models\Reputation_history;
use App\Models\Users;

use App\Repositories\Reputation_historyRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Reputation_historyRepository extends BaseRepository implements Reputation_historyRepositoryInterface
{
    public function __construct(Reputation_history $model)
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

        $query->with('user_id');

        if (isset($params['filter'])) {
            $filter = $params['filter'];

            if (isset($filter['action'])) {
                $query->where('action', 'like', '%'.$filter['action'].'%');
            }

            if (isset($filter['reputation_change'])) {
                $query->where('reputation_change', 'like', '%'.$filter['reputation_change'].'%');
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
            $reputation_history = Reputation_history::create([
                    'user_id' => $attributes['user_id'] ?? null
,
                    'action' => $attributes['action'] ?? null
,
                    'reputation_change' => $attributes['reputation_change'] ?? null
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
            $reputation_history = Reputation_history::find($id);
            $reputation_history->update([
                    'user_id' => $attributes['user_id'] ?? null
,
                    'action' => $attributes['action'] ?? null
,
                    'reputation_change' => $attributes['reputation_change'] ?? null
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
            ->with('user_id')
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

