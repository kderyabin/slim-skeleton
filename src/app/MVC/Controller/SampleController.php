<?php
/**
 * Copyright (c) 2018 Konstantin Deryabin <kderyabin@orange.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\MVC\Controller;

use App\MVC\View\SampleView;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * SampleController
 */
class SampleController extends AbstractController
{
    /**
     * Sample method for generating some content with the SampleView
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function main($request, $response)
    {
        $view = new SampleView($this->ci);
        $view->server =$this->ci->get('environment')->all();
        $view->title = $request->getAttribute('title');
        return $view->getResponse($response);
    }
}
