<?php
namespace LWS\GaveBloemen\CMS\Controller;

use Silex\Application;

class IndexController
{
    public function get(Application $app)
    {
        return $app['twig']->render('index.twig', array(
            'title' => 'CMS',
        ));
    }
}