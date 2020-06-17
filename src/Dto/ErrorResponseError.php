<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Dto;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ErrorResponseError
 *
 * @package F1Monkey\RequestHandleBundle\Dto
 */
class ErrorResponseError
{
    /**
     * Request field
     *
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Serializer\SerializedName("field")
     * @Serializer\Type("string")
     */
    protected string $field;

    /**
     * Error message
     *
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Serializer\SerializedName("message")
     * @Serializer\Type("string")
     */
    protected string $message;

    /**
     * ErrorResponseError constructor.
     *
     * @param string $field
     * @param string $message
     */
    public function __construct(string $field, string $message)
    {
        $this->field   = $field;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}