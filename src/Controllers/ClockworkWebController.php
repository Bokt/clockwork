<?php

namespace Reflar\Clockwork\Controllers;

use Clockwork\Web\Web;
use Flarum\Http\Exception\RouteNotFoundException;
use Flarum\User\Exception\PermissionDeniedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

class ClockworkWebController implements RequestHandlerInterface
{
    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!app('clockwork.authenticator')->check($request)) {
            throw new PermissionDeniedException();
        }

        if ($asset = (new Web())->asset('app.html')) {
            return new Response(
                new Stream($asset['path'])
            );
        }

        throw new RouteNotFoundException();
    }
}
