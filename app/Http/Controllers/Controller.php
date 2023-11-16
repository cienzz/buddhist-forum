<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use MongoDB\Laravel\Eloquent\Builder;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct(Request $request) 
    {
        //  validate parameters
        $this->validate($request, [
            '*.value'    => 'required_with:*.operator',
            '*.operator' => 'required_with:*.value',
            'order_by.*' => 'in:asc,desc'
        ]);
    }

    /**
     * It returns a JSON response with a 422 status code and an array of errors with a single error
     * message
     * 
     * @param string message, The error message you want to display
     * @param integer statusCode, The HTTP status code to return.
     * 
     * @return JsonResponse A JSON response with the error message.
     */
    protected function error($message, $statusCode = 422)
    {
        return response()->json(['message' => $message], $statusCode);
    }

    protected function simplePaginate(Builder $query, $resource = null, $callback = null)
    {
        $orders = request()->has('order_by') ? request('order_by') : [];
        foreach(collect($orders) as $field => $value) {
            $query->orderBy($field, $value);
        }

        $paginator = $query->simplePaginate();
        $result = [
            'per_page' => $paginator->perPage(),
            'has_more' => $paginator->hasMorePages(),
            'data' => $resource ? $resource::collection($paginator) : $paginator->items()
        ];
        if ($callback && $callback instanceof Closure) {
            $result = $callback($result, $paginator);
        }
        return response()->json($result);
    }

    /**
     * It takes a query builder, a number of items per page, and a callback function, and returns a
     * paginated response
     * 
     * @param Builder query, The query builder object
     * @param string resource JsonResource class string
     * @param numeric itemsPerPage, The number of items per page. If not specified, it will be taken from the
     * request.
     * @param callback A callback function that will be called after the pagination is done.
     * 
     * @return JsonResponse A paginated response.
     */
    protected function paginate(Builder $query, $resource = null, $callback = null)
    {
        $orders = request()->has('order_by') ? request('order_by') : [];
        foreach(collect($orders) as $field => $value) {
            $query->orderBy($field, $value);
        }

        $paginator = $query->paginate();
        $result = [
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'data' => $resource ? $resource::collection($paginator) : $paginator->items()
        ];
        if ($callback && $callback instanceof Closure) {
            $result = $callback($result, $paginator);
        }
        return response()->json($result);
    }
}
