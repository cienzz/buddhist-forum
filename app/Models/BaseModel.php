<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Builder;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 25;
    
    /**
     * The attributes that are filterable.
     *
     * @var array<int, string>
     */
    protected $filterable = [];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = []) 
    {
        parent::__construct($attributes);

        if (request()->has('per_page')) {
            $this->setPerPage(min(request('per_page') ?: 0, $this->perPage));
        }
    }

    /**
     * It takes a request object, and filters the query based on the request parameters
     * 
     * @param Builder query The query builder instance
     * @param mixed data
     * 
     * @return Builder A query builder object
     */
    public function scopeFilter(Builder $query, $data) 
    {
        $params = collect($data)->only($this->getFilterable());

        foreach($params as $field => $param) {
            $operator = isset($param['operator']) ? $param['operator'] : '=';
            
            if (isset($param['value'])) {
                if (is_array($param['value'])) {
                    $value = [];
                    foreach($param['value'] as $temp) {
                        $value[] = $this->transformModelValue($field, $temp);
                    }
                } else {
                    $value = $this->transformModelValue($field, $param['value']);
                }
            } else {
                $value = $this->transformModelValue($field, $param);
            }

            if ($operator == 'in') {
                $query->whereIn($field, collect($value)->toArray());
            } else if ($operator == 'between') {
                $query->whereBetween($field, collect($value)->toArray());
            } else {
                $query->where($field, $operator, $value);
            }
        }
    }

    protected function getFilterable(): array
    {
        return array_merge([$this->getKeyName()], $this->getDates(), $this->filterable);
    }
}
