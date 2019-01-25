<?php

namespace Wxm\DDoc\Annotation;

/**
 * @Annotation
 */
class Transaction
{
    /**
     * @array<Request|Response>
     */
    public $value;
}
