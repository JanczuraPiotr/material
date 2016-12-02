<?php
namespace Pjpl\MaterialBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pjpl\MaterialBundle\Entity\Material;
use Pjpl\MaterialBundle\Form\MaterialForm;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class MaterialController extends Controller{

	public function indexAction(){
		return $this->render('PjplMaterialBundle:Material:index.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
	}

	public function addAction(Request $request){
		$return = $this->redirectToRoute('material_material');

		$materialEntity = new Material();

		$form = $this->createForm(MaterialForm::class, $materialEntity);
		$form->handleRequest($request);

		try{
			if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){
				if($form->isValid()) {
					try{
						$materialEntity = $form->getData();
						$em = $this->getDoctrine()->getManager();
						$em->persist($materialEntity);
						$em->flush();
						$return = $this->render('PjplMaterialBundle:Material:index.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
					} catch (UniqueConstraintViolationException $ex){
						$this->get('session')->getFlashBag()->add('info','Materiał jest już w bazie danych');
						$return = $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
					}
				}else{
					$return = $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
				}
			}else if($form->get('cancel')->isClicked()){
				$return = $this->render('PjplMaterialBundle:Material:index.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
			}else{
				$return = $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
			}
		} catch (Exception $ex) {
				$this->get('session')->getFlashBag()->add('info','Nieznany błąd');
				$return = $this->redirectToRoute('material_material');
		}

		return $return;
	}
	public function listAction(Request $request){
		return $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
	}
	public function editAction(Request $request, $id){
		$return = $this->redirectToRoute('material_material');
		$em = $this->container->get('doctrine')->getManager();
		$jmRepo = $em->getRepository('PjplMaterialBundle:Material');
		$materialEntity = $jmRepo->find($id);

		$form = $this->createForm(MaterialForm::class, $materialEntity);
		$form->handleRequest($request);

		try{
			if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){
				if($form->isValid()) {
					try{
						$materialEntity = $form->getData();
						$em = $this->getDoctrine()->getManager();
						$em->persist($materialEntity);
						$em->flush();
						$return = $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
					} catch (UniqueConstraintViolationException $ex){
						$this->get('session')->getFlashBag()->add('info','Materiał jest już w bazie danych');
						$return = $this->render('PjplMaterialBundle:Material:edit.html.twig',['form' => $form->createView()]);
					}
				}else{
					$return = $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
				}
			}else if($form->get('cancel')->isClicked()){
				$return = $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
			}else{
				$return = $this->render('PjplMaterialBundle:Material:edit.html.twig',['form' => $form->createView()]);
			}
		} catch (Exception $ex) {
				$this->get('session')->getFlashBag()->add('info','Nieznany błąd');
				$return = $this->redirectToRoute('material_material');
		}

		return $return;
	}
}