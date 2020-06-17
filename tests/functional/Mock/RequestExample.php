<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Tests\functional\Mock;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RequestExample
 *
 * @package F1Monkey\RequestHandleBundle\Tests\functional\Mock
 */
class RequestExample implements RequestInterface
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     */
    protected string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return RequestExample
     */
    public function setName(string $name): RequestExample
    {
        $this->name = $name;

        return $this;
    }
}