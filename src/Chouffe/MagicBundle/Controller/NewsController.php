<?php

namespace Chouffe\MagicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Chouffe\MagicBundle\Entity\News;

class NewsController extends Controller
{

    public function fetchAction(News $news)
    {
        $response = new Response();        
        $response->headers->set('Content-Type', 'application/json');
        $json = array('title' => $news->getTitle(), 'date' => $news->getDate(), 'content' => $news->getContent());
        $response->setContent(json_encode($json));
        
        return $response;
    }

    // FIXME: add Security ADMIN only
    public function addAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $news = new News();
        $news->setTitle('Title');
        $news->setContent('Content of The news');
    
        $em->persist($news);
        $em->flush();
        
        return new Response('1');
    }

    public function updateAction(News $news)
    {
    }

    // TODO: add security ADMIN only
    public function deleteAction(News $news)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($news);
        
        $response = new Response('1');        
        $em->flush();
        return $response;
    }

    public function indexAction($name)
    {
        return $this->render('ChouffeMagicBundle:Default:index.html.twig', array('name' => $name));
    }

}

