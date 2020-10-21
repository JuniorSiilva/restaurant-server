<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use Illuminate\Http\Request;
use App\Exceptions\BusinessException;

class CheckModelExists
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $params
     * @return mixed
     */
    public function handle($request, Closure $next, string $params)
    {
        $params = explode('|', $params);

        $table = $params[0];
        $value = $request->route()->parameter($params[1]);
        $column = $params[2] ?? 'id';
        $deleted_at = $params[3] ?? null;

        $query = DB::table($table);

        $query->select($column);

        if ($deleted_at) {
            $query->whereNull($deleted_at);
        }

        if (! $query->where($column, $value)->exists()) {
            throw new BusinessException(__('messages.ROUTE_PARAM_MODEL_NOT_FOUND_EXCEPTION', ['resource' => $table]));
        }

        return $next($request);
    }
}
