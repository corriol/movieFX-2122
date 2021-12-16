<?php

namespace App;

class Request {
    const GET = 'GET';
    const POST = 'POST';

    private $domain;
    private $path;
    private $method;
    private $request;
    private $query;
    private $cookies;

    public function __construct() {
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->path = explode('?', $_SERVER['REQUEST_URI'])[0];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query = new FilteredMap($_GET);
        $this->request = new FilteredMap($_POST);
        $this->cookies = new FilteredMap($_COOKIE);
    }

    public function getUrl(): string {
        return $this->domain . $this->path;
    }

    public function getDomain(): string {
        return $this->domain;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function isPost(): bool {
        return $this->method === self::POST;
    }

    public function isGet(): bool {
        return $this->method === self::GET;
    }

    public function getRequest(): FilteredMap {
        return $this->request;
    }
    
    public function getQuery(): FilteredMap {
        return $this->query;
    }

    public function getCookies(): FilteredMap {
        return $this->cookies;
    }
}
