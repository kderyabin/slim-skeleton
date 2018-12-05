<?php

namespace App\MVC\View;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;

/**
 * AbstractView
 */
abstract class AbstractView extends PhpRenderer
{
    /**
     * Template file name without extension
     * @var string
     */
    protected $template = '';
    /**
     * Template file default extension
     * @var string
     */
    protected $ext = '.phtml';

    /**
     * AbstractView constructor.
     * @param ContainerInterface $ci
     * @param array $attributes
     */
    public function __construct(ContainerInterface $ci, array $attributes = [])
    {
        if ($ci->has('settings')) {
            $settings = $ci->get('settings');
            if (!empty($settings['renderer']['template_path'])) {
                parent::__construct($settings['renderer']['template_path']);
            }
        }
    }

    /**
     * Returns parsed content of the template.
     * Wrapper for PhpRenderer::fetch method
     * @return string
     */
    public function fetchContent(): string
    {
        return parent::fetch($this->getTemplateFile());
    }

    /**
     * Template file name with extension
     * @return string
     */
    protected function getTemplateFile()
    {
        return $this->template . $this->ext;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->fetchContent();
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getResponse(ResponseInterface $response)
    {
        $response->getBody()->write($this->fetchContent());

        return $response;
    }
}