<?php

namespace computerShop\base;

abstract class Controller
{
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public array $data = [];
    public array $meta = ['title' => '', 'description' => '', 'keywords' => ''];

    public function __construct($route)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];
    }

    /**
     * @throws \Exception
     */
    public function getView()
    {
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setMeta($title = '', $description = '', $keywords = '')
    {
        $this->meta = [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords
        ];
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function loadView($view, $vars = [])
    {
        extract($vars);
        // Check first in controller-specific views
        $viewFile = APP . "/views/pages/{$this->controller}/{$view}.php";
        if (!is_file($viewFile)) {
            // Then check in components
            $viewFile = APP . "/views/components/{$view}.php";
        }
        if (is_file($viewFile)) {
            require $viewFile;
        }
        die;
    }

    public function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }

    protected function error($code, $message = '')
    {
        http_response_code($code);

        if ($this->isAjax()) {
            return $this->jsonResponse(['error' => $message ?: 'Error occurred']);
        }

        require WWW . "/errors/{$code}.php";
        die;
    }
}
