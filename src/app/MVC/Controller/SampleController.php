<?php
/**
 * Copyright (c) 2018 Konstantin Deryabin <kderyabin@orange.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\MVC\Controller;

use App\MVC\View\SampleView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * SampleController
 */
class SampleController extends AbstractController
{
    /**
     * Sample method for generating some content with the SampleView
     *
     * @param $request
     * @param $response
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function main($request, $response)
    {
        $view = new SampleView($this->ci);
        $view->server = $_SERVER;
        $view->title = $request->getAttribute('title');
        return $view->getResponse($response);
    }
}
