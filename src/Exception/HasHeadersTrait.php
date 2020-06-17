<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception;

/**
 * Trait HasHeadersTrait
 *
 * @package F1Monkey\RequestHandleBundle\Exception
 */
trait HasHeadersTrait
{
    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}