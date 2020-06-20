<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use F1Monkey\RequestHandleBundle\Dto\ErrorResponse;
use F1Monkey\RequestHandleBundle\Dto\ErrorResponseError;
use F1Monkey\RequestHandleBundle\Exception\UserFriendlyExceptionInterface;
use F1Monkey\RequestHandleBundle\Exception\Validation\ValidationExceptionInterface;
use JMS\Serializer\ArrayTransformerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

/**
 * Class ErrorResponseFactory
 *
 * @package App\Factory\Api\V1
 */
class JsonErrorResponseFactory implements ErrorResponseFactoryInterface
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var ArrayTransformerInterface
     */
    protected ArrayTransformerInterface $arrayTransformer;

    /**
     * JsonErrorResponseFactory constructor.
     *
     * @param TranslatorInterface       $translator
     * @param ArrayTransformerInterface $arrayTransformer
     */
    public function __construct(TranslatorInterface $translator, ArrayTransformerInterface $arrayTransformer)
    {
        $this->translator       = $translator;
        $this->arrayTransformer = $arrayTransformer;
    }

    /**
     * @param Throwable $exception
     *
     * @return ErrorResponse
     */
    public function createErrorResponse(Throwable $exception): object
    {
        return new ErrorResponse($this->getErrorMessage($exception), $this->getRequestErrors($exception));
    }

    /**
     * @param object $errorResponse
     * @param int    $httpStatusCode
     *
     * @return Response
     */
    public function createResponse(object $errorResponse, int $httpStatusCode): Response
    {
        return new JsonResponse($this->arrayTransformer->toArray($errorResponse), $httpStatusCode);
    }

    /**
     * @param Throwable $exception
     *
     * @return string
     */
    protected function getErrorMessage(Throwable $exception): string
    {
        if ($exception instanceof UserFriendlyExceptionInterface) {
            return $this->translator->trans($exception->getMessage());
        }

        if ($exception instanceof HttpExceptionInterface) {
            return Response::$statusTexts[$exception->getStatusCode()];
        }

        return Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
    }

    /**
     * @param Throwable $exception
     *
     * @return Collection<int, ErrorResponseError>|null
     */
    protected function getRequestErrors(Throwable $exception): ?Collection
    {
        if (!$exception instanceof ValidationExceptionInterface) {
            return null;
        }

        if (!$exception instanceof UserFriendlyExceptionInterface) {
            return null;
        }

        $messages = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($exception->getViolations() as $violation) {
            $messages[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        $result = new ArrayCollection();
        foreach ($messages as $path => $messageGroup) {
            $result->add(
                new ErrorResponseError($path, implode(' ', $messageGroup))
            );
        }

        return $result;
    }
}