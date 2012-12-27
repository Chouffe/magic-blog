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
        
            $this->get('session')->getFlashBag()->add('info', 'Event saved');
            return $this->redirect($this->generateUrl('home'));
        }

        $this->get('session')->getFlashBag()->add('error', 'Error while saving the event');
        return $this->redirect($this->generateUrl('home'));
    }
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        $this->get('session')->getFlashBag()->add('info', 'Event deleted');
        return $this->redirect($this->generateUrl('home'));
    }

    public function agendaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:Event');
        $eventList = $repo->findBy(array(), array('date' => 'desc'));

        $event = new Event();
        $formEvent = $this->createForm(new EventType, $event);

        return $this->render('ChouffeMagicBundle:Default:event.html.twig', array('formEvent' => $formEvent->createView(), 'eventList' => $eventList));

    }

    public function seeAction(Event $event)
    {
        return $this->render('ChouffeMagicBundle:Default:event-zoom.html.twig', array('event' => $event));
    }

    public function seeAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:Event');
        $eventList = $repo->findBy(array(), array('date' => 'desc'));

        return $this->render('ChouffeMagicBundle:Default:calendar.html.twig', array('eventList' => $eventList));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function addFormAction()
    {
        $event = new Event();
        $form = $this->createForm(new EventType, $event);

        // return new Response('Salut');
        return $this->render('ChouffeMagicBundle:forms:event.html.twig', array('form' => $form->createView()));
    }
}
