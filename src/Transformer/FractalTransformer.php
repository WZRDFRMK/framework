<?php

namespace Wzrd\Framework\Transformer;

use League\Fractal;
use Wzrd\Contracts\Transformer\Transformer;

class FractalTransformer implements Transformer
{
    /**
     * Fractal.
     *
     * @var League\Fractal\Manager
     */
     protected $fractal;

    /**
     * Create a new fractal transformer instance.
     *
     * @param League\Fractal\Manager $fractal
     */
    public function __construct(Fractal\Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Transform a response with a transformer.
     *
     * @param mixed  $value
     * @param object $transformer
     * @param array $includes Optional
     *
     * @return array
     */
    public function transform($value, $transformer, $includes = array())
    {
        if(!empty($includes)) {
            $this->fractal->parseIncludes(implode(',', $includes));
        }

        if (is_array($value)) {
            // TODO : support cursor current / prev / next
            $cursor = new Fractal\Pagination\Cursor(null, null, null, count($value));
            $resource = new Fractal\Resource\Collection($value, $transformer);
            $resource->setCursor($cursor);
        } else {
            $resource = new Fractal\Resource\Item($value, $transformer);
        }

        $data = $this->fractal->createData($resource);

        return $data->toArray();
    }
}
