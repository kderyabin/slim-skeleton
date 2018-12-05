<?php

namespace App\MVC\Controller;

use Psr\Container\ContainerInterface;

/**
 * AbstractController
 */
abstract class AbstractController
{
    /**
     * @var ContainerInterface
     */
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }
}
