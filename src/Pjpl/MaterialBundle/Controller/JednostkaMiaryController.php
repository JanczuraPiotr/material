<?php
namespace Pjpl\MaterialBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pjpl\MaterialBundle\Entity\JednostkaMiary;
use Pjpl\MaterialBundle\Form\JednostkaMiaryForm;
use Symfony\Component\HttpFoundation\Request;

class JednostkaMiaryController extends Controller{
	public function indexAction(){
		return $this->render('PjplMaterialBundle:JednostkaMiary:index.html.twig',['material_array' => $this->get('material.zestawienie')->getArray()]);
	}

	public function addAction(Request $request){
		$jednostkaMiary = new JednostkaMiary();

		$form = $this->createForm(new JednostkaMiaryForm(), $jednostkaMiary);
		$form->handleRequest($request);

		if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){

			if($form->isValid()) {
				$jednostkaMiary = $form->getData();
				$em = $this->getDoctrine()->getManager();
				$em->persist($jednostkaMiary);
				$em->flush();
				return $this->redirectToRoute('material_homepage');
			}

		}else if($form->get('cancel')->isClicked()){
			return $this->redirectToRoute('material_homepage');
		}else{
			return $this->render('PjplMaterialBundle:JednostkaMiary:add.html.twig',['form' => $form->createView()]);
		}

	}
	public function editAction(){

		return $this->render('PjplMaterialBundle:JednostkaMiary:edit.html.twig');
	}
}