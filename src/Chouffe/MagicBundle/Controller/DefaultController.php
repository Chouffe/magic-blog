<?php

namespace Chouffe\MagicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Chouffe\MagicBundle\Entity\News;
use Chouffe\MagicBundle\Form\NewsType;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $news = new News();
        $form = $this->createForm(new NewsType(), $news);
        return $this->render('ChouffeMagicBundle:Default:index.html.twig', array('name' => $name, 'form' => $form->createView()));
    }
}
