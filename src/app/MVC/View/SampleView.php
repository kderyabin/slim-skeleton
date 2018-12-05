<?php

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
