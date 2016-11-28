<?php
namespace Pjpl\MaterialBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pjpl\MaterialBundle\Entity\Material;
use Pjpl\MaterialBundle\Form\MaterialyForm;

class MaterialController extends Controller{
	
	public function indexAction(){
		return $this->render('PjplMaterialBundle:Material:index.html.twig',['material_array' => $this->get('material.zestawienie')->getArray()]);
	}

	public function addAction(Request $request){
		$material = new Material();

		$form = $this->createForm(new MaterialyForm(), $material);
		$form->handleRequest($request);

		if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){

			if($form->isValid()) {
				$material = $form->getData();
				$em = $this->getDoctrine()->getManager();
				$em->persist($material);
				$em->flush();
				return $this->redirectToRoute('material_homepage');
			}

		}else if($form->get('cancel')->isClicked()){
			return $this->redirectToRoute('material_homepage');
		}else{
			return $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
		}

	}
	public function editAction(){
		return $this->render('PjplMaterialBundle:Material:edit.html.twig');
	}
}