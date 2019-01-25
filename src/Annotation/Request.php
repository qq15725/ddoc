<?php

namespace Wxm\DDoc\Annotation;

/**
 * @Annotation
 */
class Request
{
    /**
     * @var mixed
     */
    public $body;

    /**
     * @var string
     */
    public $contentType = 'application/json';

    /**
     * @var string
     */
    public $identifier;

    /**
     * @var array
     */
    public $headers = [];

    /**
     * @var array<Wxm\DDoc\Annotation\Attribute>
     */
    public $attributes;
}
