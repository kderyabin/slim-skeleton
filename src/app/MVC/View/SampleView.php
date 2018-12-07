<?php
/**
 * Copyright (c) 2018 Konstantin Deryabin <kderyabin@orange.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\MVC\View;

/**
 * SampleView
 */
class SampleView extends AbstractView
{
    /**
     * Template name
     * @var string
     */
    protected $template = 'sample-view';
    /**
     * Server data to display
     * @var array
     */
    public $server = [];
    /**
     * Parameter fetch from the request
     * @var string
     */
    public $title = '';
}
