<?php

namespace Aqfaridi\EventCalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EventCalendarBundle:Default:index.html.twig');
    }
}
