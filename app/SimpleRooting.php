<?php

namespace app;

class SimpleRooting extends \Symfony\Component\Routing\RouteCollection
{
    private $prefix = '';
    private $fullRest = false;

    public function __construct($prefix = '', $fullRest = false)
    {
        $this->prefix = $prefix;
        $this->fullRest = $fullRest;
    }

    public function addSimple($url, $controller, $action, $method, $access=null)
    {
        $methods = ($method !== 'GET') ? [$method, "OPTIONS"] : [$method];

        if (!$this->fullRest && in_array($method, ['PATCH', 'DELETE'])) {
            $methods = ['POST', "OPTIONS"];
            if ($method === 'DELETE') {
                $url .= '/delete';
            } else {
                $url .= '/update';
            }
        }

        $this->add(
            $this->getName($url, $method),
            new \Symfony\Component\Routing\Route(
                $this->prefix . $url,
                array(
                    'controller' => $controller,
                    'action' => $action,
                    'access' => $access
                ),
                array(),
                array(),
                '',
                array(),
                $methods
            )
        );
    }

    private function getName($url, $method) {
       return $url . ":" . $method;
    }
}