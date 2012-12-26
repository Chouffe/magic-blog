<?php

namespace Chouffe\MagicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Chouffe\MagicBundle\Entity\Event;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Chouffe\MagicBundle\Form\EventType;


class EventController extends Controller
{
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function addAction()
    {
        $event = new Event();
        $form = $this->createForm(new EventType, $event);

        // La gestion d'un formulaire est particulière, mais l'idée est la suivante 
        if( $this->get('request')->getMethod() == 'POST' )
        {
            // Ici, on s'occupera de la création et de la gestion du formulaire
            $request = $this->get('request');
            $form->bind($request);
        
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        
            $this->get('session')->getFlashBag()->add('notice', 'Event saved');
            return new Response('1');
        }

        
        return new Response('0');
    }
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        
        $response = new Response('1');        
        $em->flush();
        return $response;
    }

    public function agendaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:Event');
        $eventList = $repo->findAll();

        $event = new Event();
        $formEvent = $this->createForm(new EventType, $event);

        return $this->render('ChouffeMagicBundle:Default:event.html.twig', array('formEvent' => $formEvent->createView(), 'eventList' => $eventList));

    }

    public function seeAction(Event $event)
    {
        return $this->render('ChouffeMagicBundle:Default:event-zoom.html.twig', array('event' => $event));
    }
}
