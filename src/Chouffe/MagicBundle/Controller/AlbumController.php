<?php

namespace Chouffe\MagicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Chouffe\MagicBundle\Entity\Album;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Chouffe\MagicBundle\Form\AlbumType;

class AlbumController extends Controller
{
    
    // TODO
    public function fetchAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:Album');
        $albumList = $repo->findAll();

        $album = new Album();
        $form = $this->createForm(new AlbumType, $album);

        return $this->render('ChouffeMagicBundle:Default:gallery.html.twig', array('page' => 'gallery', 'form' => $form->createView(), 'albumList' => $albumList));
        

    }
   
    public function fetchAction(Album $album)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:Photo');
        $photosList = $repo->findBy(array(), array('id' => 'desc'));

        $news = new News();
        $form = $this->createForm(new NewsType, $news);

        return $this->render('ChouffeMagicBundle:Default:news.html.twig', array('page' => 'home', 'form' => $form->createView(), 'newsList' => $newsList));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function addAction()
    {
        $album = new Album();
        $form = $this->createForm(new AlbumType, $album);

        // La gestion d'un formulaire est particulière, mais l'idée est la suivante 
        if( $this->get('request')->getMethod() == 'POST' )
        {
            // Ici, on s'occupera de la création et de la gestion du formulaire
            $request = $this->get('request');
            $form->bind($request);
        
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();
        
            $this->get('session')->getFlashBag()->add('notice', 'Album saved');
            return new Response('1');
        }

        
        return new Response('0');
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction(Album $album)
    {
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Album $album)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($album);
        
        $response = new Response('1');        
        $em->flush();
        return $response;
    }

}

