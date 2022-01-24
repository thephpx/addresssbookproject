<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


use AppBundle\Entity\Address;
use AppBundle\Form\AddressType;
use AppBundle\Service\Uploader;

class AddressController extends Controller
{
    /**
     * @Route("/", name="listAddress")
     */
    public function indexAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $search_query = $request->query->get('search');

        if(empty($search_query)){
            $query = $this->getDoctrine()->getRepository(Address::class)->findAll();
        } else {
            $query = $this->getDoctrine()->getRepository(Address::class)->createQueryBuilder('a')
                        ->where('a.firstname = :query')
                        ->orWhere('a.lastname = :query')
                        ->orWhere('a.email = :query')
                        ->orWhere('a.phonenumber = :query')
                        ->setParameter('query', $search_query)
                        ->getQuery()->getResult();
        }

        $paginator = $this->get('knp_paginator');
        $rows = $paginator->paginate($query, $request->query->getInt('page',1),$request->query->getInt('limit',10));

        return $this->render('default/index.html.twig', ['rows'=>$rows,'search_query'=>$search_query]);
    }

    /**
     * @Route("/create", name="createAddress")
     */
    public function createAction(Request $request, Uploader $uploader)
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $address = $form->getData();

            // $pictureFile = $form->get('picture')->getData();

            // if ($pictureFile) {
            //     $pictureFileName = $uploader->upload($pictureFile);
            //     $address->setPicture($pictureFileName);
            // }
            
            $entityManager = $this->getDoctrine()->getManager();                
            $entityManager->persist($address);
            $entityManager->flush();

            # Used a custom convention to pass alert type and message together separated by |
            $this->addFlash('alert_messages', 'success|Address created successfully');
            return $this->redirectToRoute('listAddress');
            
        }


        return $this->render('default/create.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/edit/{addressId}", name="editAddress")
     */
    public function editAction(Request $request, Int $addressId, Uploader $uploader)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $address = $this->getDoctrine()->getRepository(Address::class)->find($addressId);

        if (!$address) {
            throw $this->createNotFoundException(
                'No address found for id '.$addressId
            );
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $address = $form->getData();

            // $pictureFile = $form->get('picture')->getData();

            // if ($pictureFile) {
            //     $pictureFileName = $uploader->upload($pictureFile);
            //     $address->setPicture($pictureFileName);
            // }
            
            $entityManager = $this->getDoctrine()->getManager();                
            $entityManager->persist($address);
            $entityManager->flush();

            # Used a custom convention to pass alert type and message together separated by |
            $this->addFlash('alert_messages', 'success|Address updated successfully');

            return $this->redirectToRoute('listAddress');
            
        }

        return $this->render('default/edit.html.twig', ['address'=>$address,'form'=>$form->createView()]);
    }

    /**
     * @Route("/view/{addressId}", name="viewAddress")
     */
    public function viewAction(Request $request, Int $addressId)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $address = $this->getDoctrine()->getRepository(Address::class)->find($addressId);

        if (!$address) {
            throw $this->createNotFoundException(
                'No address found for id '.$addressId
            );
        }

        return $this->render('default/view.html.twig', ['row'=>$address]);
    }

    /**
     * @Route("/delete/{addressId}", name="deleteAddress")
     */
    public function deleteAction(Request $request, Int $addressId)
    {

        $address = $this->getDoctrine()->getRepository(Address::class)->find($addressId);

        if (!$address) {
            throw $this->createNotFoundException(
                'No address found for id '.$addressId
            );
        }

        $form = $this->createFormBuilder($address)
                    ->add('firstname', HiddenType::class)
                    //->add('remove', SubmitType::class, ['attr'=>['class'=>'btn btn-danger'],'label' => 'Confirm'])
                    //->add('cancel', SubmitType::class, ['attr'=>['class'=>'btn btn-secondary'],'label' => 'Cancel'])
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($address);
            $entityManager->flush();

            # Used a custom convention to pass alert type and message together separated by |
            $this->addFlash('alert_messages', 'success|Address removed successfully');

            return $this->redirectToRoute('listAddress');

        }

        return $this->render('default/delete.html.twig', ['form'=>$form->createView()]);
    }
}
