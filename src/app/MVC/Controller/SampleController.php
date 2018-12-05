<?php

namespace App\MVC\Controller;

use App\MVC\View\SampleView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

/**
 * SampleController
 */
class SampleController extends AbstractController
{
    /**
     * Sample method for generating some content with the SampleView
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function main($request, $response, $args)
    {
        $view = new SampleView($this->ci);
        $view->server = $_SERVER;
        $view->title = $request->getAttribute('title');
        return $view->getResponse($response);
    }
}
