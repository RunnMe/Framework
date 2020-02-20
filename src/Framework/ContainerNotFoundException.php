<?php

namespace Runn\Framework;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class ContainerNotFoundException
 * @package Runn\Framework
 */
class ContainerNotFoundException  extends ContainerException  implements NotFoundExceptionInterface
{

    /**
     * @var string
     */
    protected $id;

    /**
     * ContainerNotFoundException constructor.
     *
     * @param string $id
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $id, $message = "", $code = 0, \Throwable $previous = null)
    {
        $this->id = $id;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

}
