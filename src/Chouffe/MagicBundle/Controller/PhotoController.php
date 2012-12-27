<?php

namespace Chouffe\MagicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Chouffe\MagicBundle\Entity\Album;
use Chouffe\MagicBundle\Entity\Photo;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Chouffe\MagicBundle\Form\PhotoType;;


class PhotoController extends Controller
{
    
    // TODO
    public function fetchAllAction()
    {
        // $response = new Response(); 
        // $response->headers->set('Content-Type', 'application/json');
        // 
        // $em = $this->getDoctrine()->getManager();
        // $photoList = $em->findAll();
        // 
        // $json = array();
        // // TODO : limit the range
        // foreach( $photoList as $photo )
        // {
        //     $json[] = array('title' => $photo->getTitle(), 'date' => $photo->getDate(), 'content' => $photo->getContent());
        // }

        // $response->setContent(json_encode($json));
        // 
        // return $response;

    }
   
    // TODO 
    public function fetchAction(Photo $photo)
    {
        // $response = new Response();        
        // $response->headers->set('Content-Type', 'application/json');
        // $json = array('title' => $photo->getTitle(), 'date' => $photo->getDate(), 'content' => $photo->getContent());
        // $response->setContent(json_encode($json));
        // 
        // return $response;
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function addAction(Album $album)
    {
        $photo = new Photo();
        $form = $this->createForm(new PhotoType, $photo);

        // La gestion d'un formulaire est particulière, mais l'idée est la suivante 
        if( $this->get('request')->getMethod() == 'POST' )
        {
            // Ici, on s'occupera de la création et de la gestion du formulaire
            $request = $this->get('request');
            $form->bind($request);
        
            $em = $this->getDoctrine()->getManager();
            $album->addPhoto($photo);
            $em->persist($photo);
            $em->persist($photo);
            $em->flush();
        
            $this->get('session')->getFlashBag()->add('info', 'Photo added');
            return $this->redirect($this->generateUrl('album_see', array('id' => $album->getId())));
        }

        $this->get('session')->getFlashBag()->add('error', 'Error while saving the photo');
        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAddAction(Photo $photo)
    {
        $form = $this->createForm(new PhotoType, $photo);

        // La gestion d'un formulaire est particulière, mais l'idée est la suivante 
        if( $this->get('request')->getMethod() == 'POST' )
        {
            // Ici, on s'occupera de la création et de la gestion du formulaire
            $request = $this->get('request');
            $form->bind($request);
        
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
        
            $this->get('session')->getFlashBag()->add('notice', 'Photo Updated');
            return new Response('1');
        }

        return new Response('0');
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction(Photo $photo)
    {
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Photo $photo)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        
        $em->flush();

        $this->get('session')->getFlashBag()->add('info', 'Photo deleted');
        return $this->redirect($this->generateUrl('album_see', array('id' => $photo->getAlbum()->getId())));
    }

}

