<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\EventListener;

use F1Monkey\RequestHandleBundle\Exception\Validation\RequestValidationException;
use F1Monkey\RequestHandleBundle\Service\RequestValidatorInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class RequestValidationListener
 *
 * @package App\EventListener
 */
class RequestValidationListener
{
    /**
     * @var RequestValidatorInterface
     */
    protected RequestValidatorInterface $requestValidator;

    /**
     * @var string
     */
    protected string $supportedClass;

    /**
     * V1RequestValidationListener constructor.
     *
     * @param RequestValidatorInterface $validator
     * @param string                    $supportedClass
     */
    public function __construct(RequestValidatorInterface $validator, string $supportedClass)
    {
        $this->requestValidator = $validator;
        $this->supportedClass   = $supportedClass;
    }

    /**
     * @param ControllerArgumentsEvent $event
     *
     * @throws RequestValidationException
     */
    public function onKernelControllerArguments(ControllerArgumentsEvent $event): void
    {
        /** @var ConstraintViolationListInterface<ConstraintViolationInterface>|null $violations */
        $violations = null;
        foreach ($event->getArguments() as $argument) {
            if (!is_a($argument, $this->supportedClass, true) || !is_object($argument)) {
                continue;
            }

            $this->requestValidator->validateRequest($argument);
        }
    }
}