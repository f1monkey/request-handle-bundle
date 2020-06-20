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
     * @var array<string, string>
     */
    protected array $headers = [];

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}