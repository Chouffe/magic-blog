<?php

namespace Chouffe\MagicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Chouffe\MagicBundle\Entity\Album;
use Chouffe\MagicBundle\Entity\Photo;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Chouffe\MagicBundle\Form\AlbumType;
use Chouffe\MagicBundle\Form\PhotoType;

class AlbumController extends Controller
{
    
    public function seeAction(Album $album)
    {
        $em = $this->getDoctrine()->getManager();

        $photo = new Photo();
        $form = $this->createForm(new PhotoType, $photo);

        return $this->render('ChouffeMagicBundle:Default:album.html.twig', array('action' => 'add', 'page' => 'gallery', 'form' => $form->createView(), 'album' => $album));

    }


    // TODO
    public function fetchAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:Album');
        $albumList = $repo->findAll();

        $album = new Album();
        $form = $this->createForm(new AlbumType, $album);

        return $this->render('ChouffeMagicBundle:Default:gallery.html.twig', array('action' => 'add', 'page' => 'gallery', 'form' => $form->createView(), 'albumList' => $albumList));
        

    }
   
    public function fetchAction(Album $album)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:Photo');
        $photosList = $repo->findBy(array(), array('id' => 'desc'));

        $news = new News();
        $form = $this->createForm(new NewsType, $news);

        return $this->render('ChouffeMagicBundle:Default:news.html.twig', array('action' => 'add', 'page' => 'home', 'form' => $form->createView(), 'newsList' => $newsList));
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
        
            $this->get('session')->getFlashBag()->add('info', 'Album added');
            return $this->redirect($this->generateUrl('gallery'));
        }

        $this->get('session')->getFlashBag()->add('error', 'Error while saving the album');
        return $this->redirect($this->generateUrl('gallery'));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAddAction(Album $album)
    {
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
        
            $this->get('session')->getFlashBag()->add('notice', 'News Updated');
            return new Response('1');
        }

        return new Response('0');
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction(Album $album)
    {
        $form = $this->createForm(new AlbumType, $album);
        return $this->render('ChouffeMagicBundle:forms:album.html.twig', array('album' => $album, 'action' => 'update', 'form' => $form->createView()));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Album $album)
    {
        $em = $this->getDoctrine()->getManager();
        foreach( $album->getPhotos() as $photo )
        {
            $em->remove($photo);
        }

        $em->remove($album);
        $em->flush();

        $this->get('session')->getFlashBag()->add('info', 'Album deleted');
        return $this->redirect($this->generateUrl('gallery'));
    }

}

