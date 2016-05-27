<?php

namespace Aqfaridi\EventCalendarBundle\Controller;

use Aqfaridi\EventCalendarBundle\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{

    /**
     * @Route("/events", name="event_list")
     */

    public function indexAction()
    {
        $events = $this -> getDoctrine()
            -> getRepository('EventCalendarBundle:Event')
            -> findAll();

        return $this->render('EventCalendarBundle:Event:index.html.twig',array('events' => $events));
    }

    /**
     * @Route("/event/create",name="event_create")
     */
    public function createAction(Request $request)
    {
        $event = new Event();

        $form = $this->createFormBuilder($event)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('category', EntityType::class, array('class' => 'EventCalendarBundle:Category','choice_label' => 'name','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('details', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('day', DateTimeType::class, array('attr' => array('class' => 'form-control-day', 'style' => 'margin-bottom:15px')))
            ->add('address', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('city', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('state', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('zipcode', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Create Event', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        // Handle Request
        $form->handleRequest($request);

        // Check Submit
        if($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $details = $form['details']->getData();
            $day = $form['day']->getData();
            $address = $form['address']->getData();
            $city = $form['city']->getData();
            $state = $form['state']->getData();
            $zipcode = $form['zipcode']->getData();

            // Get Current Date and Time
            $now = new \DateTime("now");

            $event->setName($name);
            $event->setCategory($category);
            $event->setDetails($details);
            $event->setDay($day);
            $event->setAddress($address);
            $event->setCity($city);
            $event->setState($state);
            $event->setZipcode($zipcode);
            $event->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();

            $em->persist($event);
            $em->flush();

            $this->addFlash(
                'notice',
                'Event Saved'
            );

            return $this->redirectToRoute('event_list');
        }
        return $this->render('EventCalendarBundle:Event:create.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/event/edit/{id}",name="event_edit")
     */
    public function editAction($id,Request $request)
    {
        $event = $this->getDoctrine()
            ->getRepository('EventCalendarBundle:Event')
            ->find($id);

        if(!$event){
            throw $this->createNotFoundException(
                'No event found for id '.$id
            );
        }

        $event->setName($event->getName());
        $event->setCategory($event->getCategory());
        $event->setDetails($event->getDetails());
        $event->setDay($event->getDay());
        $event->setAddress($event->getAddress());
        $event->setCity($event->getCity());
        $event->setState($event->getState());
        $event->setZipcode($event->getZipCode());

        $form = $this->createFormBuilder($event)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('category', EntityType::class, array('class' => 'EventCalendarBundle:Category','choice_label' => 'name','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('details', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('day', DateTimeType::class, array('attr' => array('class' => 'form-control-day', 'style' => 'margin-bottom:15px')))
            ->add('address', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('city', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('state', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('zipcode', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Create Event', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        // Handle Request
        $form->handleRequest($request);

        // Check Submit
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $details = $form['details']->getData();
            $day = $form['day']->getData();
            $address = $form['address']->getData();
            $city = $form['city']->getData();
            $state = $form['state']->getData();
            $zipcode = $form['zipcode']->getData();

            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository('EventCalendarBundle:Event')->find($id);

            $event->setName($name);
            $event->setCategory($category);
            $event->setDetails($details);
            $event->setDay($day);
            $event->setAddress($address);
            $event->setCity($city);
            $event->setState($state);
            $event->setZipcode($zipcode);

            $em->flush();

            $this->addFlash(
                'notice',
                'Event Updated'
            );

            return $this->redirectToRoute('event_list');
        }

        // Render Template
        return $this->render('EventCalendarBundle:Event:edit.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/event/delete/{id}",name="event_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventCalendarBundle:Event')->find($id);

        if(!$event){
            throw $this->createNotFoundException(
                'No event found with id of '.$id
            );
        }

        $em->remove($event);
        $em->flush();

        $this->addFlash(
            'notice',
            'Event Deleted'
        );

        return $this->redirectToRoute('event_list');
    }
}
