<?php

namespace App\TU;

use Slim\Http\Environment;


/**
 * Env
 */
class Env
{
    /**
     * @var Environment
     */
    public $env;

    public function __construct(array $data = [])
    {
        $this->env = Environment::mock($data);
    }

    /**
     * @param array $files
     * @return $this
     */
    public function setUploadedFiles(array $files=[])
    {
        $this->env->set('slim.files', $files );
        return $this;
    }

    /**
     * Set POST data
     * @param string $data
     * @return $this
     */
    public function setPostData($data = '')
    {
        $_POST = is_string($data) ? $data : http_build_query($data);

        return $this;
    }
}
