<?php


namespace App\Middleware;

use App\Mapper\EntityMapperInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;
use Zend\Expressive\Router\RouteResult;

class Middleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $qp = $request->getQueryParams();
        /** @var RouteResult $m */
        $m = $request->getAttribute(RouteResult::class);
        $route = $m->getMatchedRoute();
        try {
            $name = $route->getName();
        } catch (Throwable $ex) {
            $result = "Error request\n***";
            $log = "\n" . date('Y-m-d H:i:s') . ":\n" . print_r($result, true);
            return $handler->handle($request);
            die();
        }
        $qt = "Method: " . "RequestTarget: " . $request->getRequestTarget();
        $result = "QueryParams: " . implode($qp) . "\n" . $qt . " name: " . $name . "\n***";
        $log = "\n" . date('Y-m-d H:i:s') . ":\n" . print_r($result, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        return $handler->handle($request);
    }
}
