<?php
namespace Routing;

use DependencyInjector\DependencyInjectionContainer;

class Router
{
    private $request;
    private $supportedMethods = [
        "GET", "POST"
    ];
    private $di;
    private $config;

    function __construct(IRequest $request, DependencyInjectionContainer $di, $config)
    {
        $this->request = $request;
        $this->di = $di;
        $this->config = $config;
    }

    function __call($name, $args)
    {
        list($route, $classMethodName, $middlewares) = $args;

        $objectMethod = explode("@", $classMethodName);
        $method = [new $objectMethod[0]($this->di, $this->config), $objectMethod[1]];

        if (!in_array(strtoupper($name), $this->supportedMethods))
        {
            $this->invalidMethodHandler();
        }
        $formattedRoute = $this->formatRoute($route);

        $this->{strtolower($name)}[$formattedRoute] = $method;

        if (!is_null($middlewares) && is_array($middlewares)) {
            $this->{strtolower($name)."-middleware"}[$formattedRoute] = $middlewares;
        }
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param string $route
     * @return string
     */
    private function formatRoute(string $route): string
    {
        $result = rtrim($route, '/');
        if ($result === '')
        {
            return '/';
        }
        return $result;
    }

    private function invalidMethodHandler()
    {
        header($this->request->serverProtocol." 405 Method Not Allowed", true, 405);
        header("Location: /405");
        die();
    }
    private function defaultRequestHandler()
    {
        header($this->request->serverProtocol." 404 Not Found", true, 404);
        header("Location: /404");
        die();
    }

    /**
     * Resolves a route
     */
    function resolve()
    {
        $method = $this->getMethod($this->request);
        if(is_null($method))
        {
            $this->defaultRequestHandler();
            return;
        }

        $middlewares = $this->getMiddlewares($this->request);
        list($middlewaresPassed, $middlewaresFailed) = $this->middlewareHandler($middlewares);
        if ($middlewaresPassed) {
            echo call_user_func_array($method, array($this->request));
        } else {
            die($middlewaresFailed);
        }
    }

    private function middlewareHandler($middlewares)
    {
        $middlewaresPassed = true;
        $middlewareFailed = "Middleware failed";
        if (!is_null($middlewares) && is_array($middlewares)) {
            foreach ($middlewares as $middleware) {
                list($returnVal, $msg) = call_user_func_array([$middleware, "apply"], array($this->request));
                if ($returnVal === false) {
                    $middlewaresPassed = false;
                    $middlewareFailed = $msg;
                    break;
                }
            }
        }

       return [$middlewaresPassed, $middlewareFailed];
    }

    private function getMiddlewares($request)
    {
        $middlewaresDictionary = $this->{strtolower($this->request->requestMethod."-middleware")};
        $formattedRoute = $this->formatRoute(strtok($request->requestUri, "?"));
        $middlewares = $middlewaresDictionary[$formattedRoute];

        return $middlewares;
    }

    private function getMethod($request)
    {
        $methodDictionary = $this->{strtolower($request->requestMethod)};
        $formattedRoute = $this->formatRoute(strtok($request->requestUri, "?"));
        $regexedFiendlyRoute = preg_quote($formattedRoute, "/");
        $regex = "/($regexedFiendlyRoute)(\/)?(\?((.*=.*)(&?))+)?/";
        $method = null;
        foreach ($methodDictionary as $k => $v) {
            if (preg_match($regex, $k)) {
                $method = $v;
                break;
            }
        }

        return $method;
    }

    function __destruct()
    {
        $this->resolve();
    }
}
