<?php


namespace App\Middleware;


use App\Mapper\EntityMapperInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AccountsMiddleware implements MiddlewareInterface
{
    /**
     * @var EntityMapperInterface
     */
    private $entityMapper;

    public function __construct(EntityMapperInterface $entityMapper)
    {
        $this->entityMapper = $entityMapper;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // TODO: Implement process() method.
    }
}