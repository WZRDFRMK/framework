<?php

namespace Wzrd\Transformer;

use League\Fractal;
use Wzrd\Contracts\Transformer;

class FractalTransformer implements Transformer
{
    /**
     * Fractal.
     *
     * @var League\Fractal\Manager
     */
    private $fractal;

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
     *
     * @return array
     */
    public function transform($value, $transformer)
    {
        if (is_array($value)) {
            $cursor = new Fractal\Pagination\Cursor(null, null, null, count($value));
            $resource = new Fractal\Resource\Collection($value, $transformer);
            $resource->setCursor($cursor);
        } else {
            $resource = new Fractal\Resource\Item($value, $transformer);
        }

        return $this->fractal->createData($resource)->toArray();
    }
}
