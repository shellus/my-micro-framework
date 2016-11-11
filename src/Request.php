<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/11
 * Time: 18:16
 */

namespace Sh;


class Request
{

    public $queryString = [];


    /**
     * @var string
     */
    protected $requestUri;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $method;



    static public function createFromWEB()
    {
        $uri = array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : '/';

        dd($uri);
        $queryString = parse_url($uri, PHP_URL_QUERY);
        $path = parse_url($uri, PHP_URL_PATH);


        $instance = new static();
        $instance->setBaseUrl($baseUrl);
        $instance->setMethod(strtoupper($_SERVER['REQUEST_METHOD']));
        $instance->setBasePath($path);
        $instance->setQueryString($queryString);
        return $instance;
    }
    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param array $queryString
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
    }
}