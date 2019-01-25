<?php

namespace Wxm\DDoc\Annotation;

/**
 * @Annotation
 */
class Parameter
{
    /**
     * @var string
     */
    public $identifier;

    /**
     * @var string
     */
    public $type = 'string';

    /**
     * @var bool
     */
    public $required = false;

    /**
     * @var string
     */
    public $description;

    /**
     * @var mixed
     */
    public $default;

    /**
     * @var mixed
     */
    public $example;

    /**
     * @array<Member>
     */
    public $members;
}
