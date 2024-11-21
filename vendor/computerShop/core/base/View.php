<?php

namespace computerShop\base;

class View
{
    public $route;
    public $controller;
    public $view;
    public $model;
    public $prefix;
    public $layout;
    public array $data = [];
    public array $meta = [];

    public function __construct($route, $layout = '', $view = '', $meta)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->view = $view;
        $this->model = $route['controller'];
        $this->prefix = $route['prefix'];
        $this->meta = $meta;
        $this->layout = $layout === false ? false : ($layout ?: LAYOUT);
    }

    /**
     * @throws \Exception
     */
    public function render($data)
    {
        if (is_array($data)) {
            extract($data);
        }

        $prefix = str_replace('\\', '/', $this->prefix);
        $controller = $this->getControllerPath($this->controller);
        $viewFile = APP . "/views/pages/{$controller}/{$this->view}.php";

        if (is_file($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        } else {
            throw new \Exception("View {$viewFile} not found", 500);
        }

        if ($this->layout !== false) {
            $layoutFile = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \Exception("Layout {$this->layout} not found", 500);
            }
        }
    }

    protected function getControllerPath($controller): string
    {
        $controllerMapping = [
            'Main' => 'home',
        ];

        $controller = strtolower($controller);
        return $controllerMapping[$controller] ?? $controller;
    }

    public function loadComponent($name, $data = [])
    {
        $componentFile = APP . "/views/components/{$name}.php";
        if (is_file($componentFile)) {
            extract($data);
            require $componentFile;
        } else {
            throw new \Exception("Component {$name} not found", 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function getPart($name, $data = [])
    {
        $partFile = APP . "/views/parts/{$name}.php";
        if (is_file($partFile)) {
            extract($data);
            require $partFile;
        } else {
            throw new \Exception("Part {$name} not found", 500);
        }
    }

    public function getMeta(): string
    {
        $output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL;
        $output .= '<meta name="description" content="' . $this->meta['description'] . '">' . PHP_EOL;
        $output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
        return $output;
    }

    public function getPage()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $pieces = explode("/", $uri);
        return $pieces[1] ?? '';
    }

    public function registerJs($file): string
    {
        $jsFile = WWW . "/assets/js/{$file}.js";
        if (is_file($jsFile)) {
            return "<script src='/assets/js/{$file}.js'></script>";
        }
        return '';
    }

    public function registerCss($file): string
    {
        $cssFile = WWW . "/assets/styles/{$file}.css";
        if (is_file($cssFile)) {
            return "<link href='/assets/styles/{$file}.css' rel='stylesheet'>";
        }
        return '';
    }
}
