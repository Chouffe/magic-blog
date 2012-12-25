<?php

namespace Chouffe\MagicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Chouffe\MagicBundle\Entity\Album;
use Chouffe\MagicBundle\Form\AlbumType;
use Chouffe\MagicBundle\Entity\News;
use Chouffe\MagicBundle\Form\NewsType;
use Chouffe\MagicBundle\Entity\Photo;
use Chouffe\MagicBundle\Form\PhotoType;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:News');
        $lastNews = $repo->find(1);
        $lastNews->setContent('test new content');
        // $newNews = new News();
        // $newNews->setContent('test');
        // $newNews->setTitle('title');
        // $em->persist($newNews);
        $em->persist($lastNews);
        $em->flush();
        // print_r($lastNews);
        $news = new News();
        $album = new Album();
        $photo = new Photo();
        $form = $this->createForm(new NewsType(), $news);
        $form2 = $this->createForm(new AlbumType, $album);
        $form3 = $this->createForm(new PhotoType, $photo);
        // return $this->render('ChouffeMagicBundle:forms:news.html.twig', array('form' => $form->createView()));
        // return $this->render('ChouffeMagicBundle:forms:photo.html.twig', array('form' => $form3->createView()));
        return $this->render('ChouffeMagicBundle:forms:album.html.twig', array('form' => $form2->createView()));
        // return $this->render('ChouffeMagicBundle:Default:index.html.twig', array('name' => $name, 'form' => $form->createView()));
    }

    public function contactAction()
    {
        return $this->render('ChouffeMagicBundle:Default:contact.html.twig', array('page' => 'contact'));
    }

    public function aboutAction()
    {
        return $this->render('ChouffeMagicBundle:Default:about.html.twig', array('page' => 'about'));
    }

    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ChouffeMagicBundle:News');
        $lastNews = $repo->find(1);
        return $this->render('ChouffeMagicBundle:Default:home.html.twig');
    }
}
