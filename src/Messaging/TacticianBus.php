<?php

namespace WZRD\Messaging;

use InvalidArgumentException;
use League\Tactician\CommandBus as BaseTacticianBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Plugins\LockingMiddleware;
use ReflectionParameter;
use WZRD\Contracts\Messaging\Bus as BusContract;
use WZRD\Contracts\Messaging\Handler as HandlerContract;
use WZRD\Contracts\Messaging\Message as MessageContract;

class TacticianBus extends BaseTacticianBus implements BusContract
{
    /**
     * Build the bus.
     *
     * @param Middleware[] $middleware
     */
    public function __construct(array $middlewares = [])
    {
        $this->init        = false;
        $this->middlewares = $middlewares;
        $this->locator     = new InMemoryLocator();
        $this->extractor   = new ClassNameExtractor();
        $this->inflector   = new HandleInflector();
    }

    /**
     * Dispatch a message to its appropriate handler.
     *
     * @param WZRD\Contracts\Messaging\Message $message
     */
    public function dispatch(MessageContract $message)
    {
        if (!$this->init) {
            $this->init = true;
            parent::__construct(array_merge($this->middlewares, [
                new LockingMiddleware(),
                new CommandHandlerMiddleware($this->extractor, $this->locator, $this->inflector),
            ]));
        }

        return $this->handle($message);
    }

    /**
     * Subscribes the handler to this bus.
     *
     * @param WZRD\Contracts\Messaging\Handler $handler
     */
    public function subscribe(HandlerContract $handler)
    {
        if (!($handler instanceof Handler)) {
            throw new InvalidArgumentException("Handler must extends WZRD\Messaging\Hanlder");
        }

        $handle_parameter_reflection = new ReflectionParameter([get_class($handler), 'process'], 0);

        $expected_message = $handle_parameter_reflection->getClass()->name;

        $this->locator->addHandler($handler, $expected_message);
    }
}
