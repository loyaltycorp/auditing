<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services\Factories;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Diactoros\ResponseFactory;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\StreamFactory;
use Zend\Diactoros\UploadedFileFactory;

class Psr7Factory implements HttpMessageFactoryInterface
{
    /**
     * @var \Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory
     */
    private $psrHttpFactory;

    /**
     * Psr7Factory constructor.
     */
    public function __construct()
    {
        $this->psrHttpFactory = new PsrHttpFactory(
            new ServerRequestFactory(),
            new StreamFactory(),
            new UploadedFileFactory(),
            new ResponseFactory()
        );
    }

    /**
     * Creates a PSR-7 Request instance from a Symfony one.
     *
     * @param \Symfony\Component\HttpFoundation\Request $symfonyRequest
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    public function createRequest(Request $symfonyRequest): ServerRequestInterface
    {
        return $this->psrHttpFactory->createRequest($symfonyRequest);
    }

    /**
     * Creates a PSR-7 Response instance from a Symfony one.
     *
     * @param \Symfony\Component\HttpFoundation\Response $symfonyResponse
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createResponse(Response $symfonyResponse): ResponseInterface
    {
        return $this->psrHttpFactory->createResponse($symfonyResponse);
    }
}
