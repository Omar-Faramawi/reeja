<?php

namespace Tamkeen\Ajeer\Transformers;

abstract class Transformer {
    
    /**
     * Function transformCollection
     *
     * This function transforms a collection of items,
     * according to the abstract transform method.
     *
     * @param array $items
     * @return array A collection of items.
     */
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }
    
    public abstract function transform($item);
}