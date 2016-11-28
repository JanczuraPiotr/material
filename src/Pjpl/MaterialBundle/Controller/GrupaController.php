<?php

namespace Pjpl\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pjpl\MaterialBundle\Form\GrupaMaterialowForm;
use Pjpl\MaterialBundle\Entity\GrupaMaterialow;

class GrupaController extends Controller
{
	public function indexAction(){
		return $this->render('PjplMaterialBundle:Grupa:index.html.twig',['material_array' => $this->get('material.zestawienie')->getArray()]);
	}

	public function addAction(Request $request){
		$grupaMaterialow = new GrupaMaterialow();

		$form = $this->createForm(new GrupaMaterialowForm(), $grupaMaterialow);
		$form->handleRequest($request);

		if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){

			if($form->isValid()) {
				$grupaMaterialow = $form->getData();
				$em = $this->getDoctrine()->getManager();
				$em->persist($grupaMaterialow);
				$em->flush();
				return $this->redirectToRoute('material_homepage');
			}

		}else if($form->get('cancel')->isClicked()){
			return $this->redirectToRoute('material_homepage');
		}else{
			return $this->render('PjplMaterialBundle:Grupa:add.html.twig',['form' => $form->createView()]);
		}
	}
	public function editAction(){
		return $this->render('PjplMaterialBundle:Grupa:edit.html.twig');
	}
	public function changeParentAction(){
		return $this->render('PjplMaterialBundle:Grupa:change-parent.html.twig');
	}
}
