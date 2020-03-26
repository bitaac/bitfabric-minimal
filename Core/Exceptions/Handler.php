<?php

namespace Bitaac\Core\Exceptions;

use Closure;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
	/**
     * Holds all the exception handlers.
     *
     * @var array
     */
    protected static $handlers = [];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Add a handler to a specific exception.
     *
     * @param  string  $exception
     * @param  \Closure  $callback
     * @return void
     */
    public function handle($exception, Closure $callback)
    {
        static::$handlers[$exception] = $callback;
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
    	if ($handler = $this->getHandler($e)) {
            return call_user_func($handler, $e, $this);
        }

        return parent::render($request, $e);
    }

    /**
     * Retrieve a custom handler based on the exception definition.
     *
     * @param  \Exception  $exception
     * @return \Closure|null
     */
    protected function getHandler(Exception $exception)
    {
        $class = get_class($exception);

        return isset(static::$handlers[$class]) ? static::$handlers[$class] : null;
    }
}
