# RequestHandleBundle

* [RequestDeserializationValueResolver](src/ArgumentValueResolver/RequestDeserializationValueResolver.php)
argument value resolver to deserialize requires parameters using jms-serializer
* [RequestValidationListener](src/EventListener/RequestValidationListener.php)
to validate request. Returns HTTP 400 response on validation error
* [ExceptionListener](src/EventListener/ExceptionListener.php) to handle application exceptions and transform them to HTTP errors
* [ExceptionLogListener](src/EventListener/ExceptionListener.php) to log application exceptions

### Configuration

```yaml
request_handle:
    value_resolver:
        # controller arguments implementing this interface will be deserialized using RequestDeserializationValueResolver
        request_class: F1Monkey\RequestHandleBundle\Tests\functional\Mock\RequestInterface
    request_validator:
        # controller arguments implementing this interface will be deserialized using RequestValidationListener
        request_class: F1Monkey\RequestHandleBundle\Tests\functional\Mock\RequestInterface
    exception_log:
        # logger service id for exception logging (default value = @logger)
        logger: 'logger'
```

### ExceptionListener

#### Custom error response

If you need to customize error response, you should override exception response factory in your application's `services.yaml`
```yaml
services:
    F1Monkey\RequestHandleBundle\Factory\ErrorResponseFactoryInterface:
        class: App\Factory\ErrorResponseFactory
```
#### Custom exception message

By default, error messages are overridden by default HTTP messages according to HTTP response code.
To set a custom error message, you should implement [UserFriendlyExceptionInterface](src/Exception/UserFriendlyExceptionInterface.php) in your Exception class.

#### X-Debug header

Because all exceptions are transformed to a "user-friendly" responses, debugging becomes harder: symfony error page will not appear at all.
To show the error page, two conditions must be met:
* `kernel.debug` parameter set to `true` (it is default setting for `dev` environment)
* `X-Debug` header is present in the request

### ExceptionLogListener

#### Customize logging

To customize logging you should override logger context provider service:
```yaml
services:
    F1Monkey\RequestHandleBundle\Service\LogContextProviderInterface:
        class: App\Service\LogContextProvider
```