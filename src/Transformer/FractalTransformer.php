<?php

namespace WZRD\Transformer;

use League\Fractal;
use Pagerfanta\Pagerfanta;
use League\Fractal\TransformerAbstract;
use WZRD\Contracts\Transformer\Transformer;
use League\Fractal\Pagination\PagerfantaPaginatorAdapter;

class FractalTransformer implements Transformer
{
     /**
      * Fractal.
      *
      * @var League\Fractal\Manager
      */
     protected $fractal;

     /**
      * Function to generate a route (for collections).
      *
      * @var callable
      */
     protected $route_generator;

    /**
     * Create a new fractal transformer instance.
     *
     * @param League\Fractal\Manager $fractal
     * @param callable               $route_generator
     */
    public function __construct(Fractal\Manager $fractal, callable $route_generator = null)
    {
        $this->fractal         = $fractal;
        $this->route_generator = is_callable($route_generator) ? $route_generator : function ($page) {return $page;};
    }

    /**
     * Transform a response with a transformer.
     *
     * @param mixed                              $value
     * @param League\Fractal\TransformerAbstract $transformer
     * @param array                              $includes    Optional
     *
     * @return array
     */
    public function transform($value, $transformer, $includes = [])
    {
        if (!empty($includes)) {
            $this->fractal->parseIncludes(implode(',', $includes));
        }

        $resource = $this->createResource($value, $transformer);

        return $this->fractal->createData($resource)->toArray();
    }

    /**
     * Create a Fractal resource instance.
     *
     * @param mixed                              $value
     * @param League\Fractal\TransformerAbstract $transformer
     *
     * @return League\Fractal\Resource\ResourceAbstract
     */
    protected function createResource($value, TransformerAbstract $transformer)
    {
        if ($value instanceof Pagerfanta) {
            $resource = new Fractal\Resource\Collection($value, $transformer);
            $resource->setPaginator(new PagerfantaPaginatorAdapter($value, $this->route_generator));
        } elseif (is_array($value)) {
            $cursor   = new Fractal\Pagination\Cursor(null, null, null, count($value));
            $resource = new Fractal\Resource\Collection($value, $transformer);
            $resource->setCursor($cursor);
        } else {
            $resource = new Fractal\Resource\Item($value, $transformer);
        }

        return $resource;
    }
}
