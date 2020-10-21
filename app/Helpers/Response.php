<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class Response
{
    private $status = 200;

    private $content = '';

    private $headers = [];

    private $resource = null;

    public function __construct($content = '', $status = 200, array $headers = [])
    {
        $this->status = $status;
        $this->content = $content;
        $this->headers = $headers;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    public function setHeaders(array $headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param Illuminate\Http\Resources\Json\JsonResource $resource
     */
    public function setResource(string $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    public function do()
    {
        return $this->getResponse()->setStatusCode($this->status)->withHeaders($this->headers);
    }

    protected function getResponse()
    {
        if ((bool) $this->resource) {
            if ($this->content instanceof Model) {
                $response = new $this->resource($this->content);
            } elseif ($this->content instanceof Collection || $this->content instanceof Paginator) {
                $response = $this->resource::collection($this->content);
            }

            return $response->response();
        }

        return new JsonResponse($this->content);
    }
}
