<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Dto;

use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ErrorResponse
 *
 * @package F1Monkey\RequestHandleBundle\Dto
 */
class ErrorResponse
{
    /**
     * Main error message
     *
     * @var string
     *
     * @Serializer\SerializedName("message")
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     */
    protected string $message;

    /**
     * Error collection (i.e. validation errors)
     *
     * @var Collection|ErrorResponseError[]|null
     *
     * @Serializer\SerializedName("errors")
     * @Serializer\Type("ArrayCollection<F1Monkey\RequestHandleBundle\Dto\ErrorResponseError>")
     */
    protected ?Collection $errors;

    /**
     * ErrorResponse constructor.
     *
     * @param string                               $message
     * @param Collection|ErrorResponseError[]|null $errors
     */
    public function __construct(string $message, Collection $errors = null)
    {
        $this->message = $message;
        $this->errors  = $errors;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return Collection|ErrorResponseError[]|null
     */
    public function getErrors(): Collection
    {
        return $this->errors;
    }
}