<?php

namespace Pjpl\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pjpl\MaterialBundle\Form\GrupaMaterialowForm;
use Pjpl\MaterialBundle\Form\GrupaMaterialowParentForm;
use Pjpl\MaterialBundle\Entity\GrupaMaterialow;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class GrupaController extends Controller
{
	public function indexAction(){
		return $this->render('PjplMaterialBundle:Grupa:index.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
	}

	public function addAction(Request $request){
		$return  = $this->redirectToRoute('material_grupa');
		$grupaMaterialow = new GrupaMaterialow();

		$form = $this->createForm(GrupaMaterialowForm::class, $grupaMaterialow);
		$form->handleRequest($request);

		try{
			if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){
				if($form->isValid()) {
					try{
						$grupaMaterialow = $form->getData();
						$em = $this->getDoctrine()->getManager();
						$em->persist($grupaMaterialow);
						$em->flush();
						$this->get('session')->getFlashBag()->add('info', 'Dodano nową grupę materiałów : '.$grupaMaterialow);
						$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
					} catch (UniqueConstraintViolationException $ex){
						$this->get('session')->getFlashBag()->add('error','Grupa materiałów jest już w bazie danych');
						$return = $this->render('PjplMaterialBundle:Grupa:add.html.twig',['form' => $form->createView()]);
					}
				}else{
					$this->get('session')->getFlashBag()->add('error','Popraw formularz');
					$return = $this->render('PjplMaterialBundle:Grupa:add.html.twig',['form' => $form->createView()]);
				}
			}else if($form->get('cancel')->isClicked()){
				$return = $this->redirectToRoute('material_grupa');
			}else{
				$return = $this->render('PjplMaterialBundle:Grupa:add.html.twig',['form' => $form->createView()]);
			}

		} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('info','Nieznany błąd');
				$return = $this->redirectToRoute('materia_grupa');
		}

		return $return;
	}
	public function listAction(Request $request){
		return $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
	}
	public function editAction(Request $request, $id){
		$return = $this->redirectToRoute('material_grupa');
		$em = $this->container->get('doctrine')->getManager();
		$grupaRepo = $em->getRepository('PjplMaterialBundle:GrupaMaterialow');
		$grupaEntity = $grupaRepo->find($request->get('id'));

		$form = $this->createForm(GrupaMaterialowForm::class, $grupaEntity);
		$form->handleRequest($request);

		try{
			if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){
				if($form->isValid()) {
					try{
						$grupaEntity = $form->getData();
						$em = $this->getDoctrine()->getManager();
						$em->persist($grupaEntity);
						$em->flush();
						$this->get('session')->getFlashBag()->add('info', 'Dokonano edycji grupy materiałów : '.$grupaEntity);
						$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
					} catch (UniqueConstraintViolationException $ex){
						$this->get('session')->getFlashBag()->add('error','Grupa jest już w bazie danych');
						$return = $this->render('PjplMaterialBundle:Grupa:edit.html.twig',['form' => $form->createView()]);
					}
				}else{
					$this->get('session')->getFlashBag()->add('error','Popraw formularz');
					$return = $this->render('PjplMaterialBundle:Grupa:add.html.twig',['form' => $form->createView()]);
				}
			}else if($form->get('cancel')->isClicked()){
				$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
			}else{
				$return = $this->render('PjplMaterialBundle:Grupa:edit.html.twig',['form' => $form->createView()]);
			}
		} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('error','Nieznany błąd');
				$return = $this->redirectToRoute('material_grupa');
		}

		return $return;

	}
	public function deleteAction(Request $request, $id, $confirm = false){
		$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);

		try{

			if($confirm){
				$em = $this->getDoctrine()->getManager();
				$grupaRepo = $em->getRepository('PjplMaterialBundle:GrupaMaterialow');
				$grupaEntity = $grupaRepo->find($id);
				try{
					$em->remove($grupaEntity);
					$em->flush();
					$this->get('session')->getFlashBag()->add('info', 'Usunięto grupę materiałów : '.$grupaEntity);
					$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
				} catch (ForeignKeyConstraintViolationException $ex){
					$this->get('session')->getFlashBag()->add('error','Usunięcie grupy materiałów : "'.$grupaEntity.'" jest niemożliwe ze względu na związanie relacjami z innymi rekordami.');
					$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
				} catch (\Exception $ex) {
					$this->get('session')->getFlashBag()->add('error','Usunięcie grupy materiałów : "'.$grupaEntity.'" nie powiodoło sie z nieznanego powodu.');
					$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',[
							'grupa_array' => $this->get('material.grupa')->getArray(),
							]);
				}
			}else{
					$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',[
							'grupa_array' => $this->get('material.grupa')->getArray(),
							'delete_id' => $id
							]);
			}

		} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('error','Nieznany błąd');
				$return = $this->redirectToRoute('material_material');

		}

		return $return;
	}

	public function changeParentAction(Request $request, $id){
		$return = $this->redirectToRoute('material_grupa');
		$em = $this->container->get('doctrine')->getManager();
		$grupaRepo = $em->getRepository('PjplMaterialBundle:GrupaMaterialow');
		$grupaEntity = $grupaRepo->find($id);

		$form = $this->createForm(GrupaMaterialowParentForm::class, $grupaEntity);
		$form->handleRequest($request);

		try{
			if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){
				if($form->isValid()) {
					try{
						$grupaEntity = $form->getData();
						$em = $this->getDoctrine()->getManager();
						$em->persist($grupaEntity);
						$em->flush();
						$this->get('session')->getFlashBag()->add('info','Zmieniono nadgrupę dla grupy : '.$grupaEntity);
						$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
					} catch (Exception $ex){
						$this->get('session')->getFlashBag()->add('error','Nie powiodła się zmiana grupy.');
						$return = $this->render('PjplMaterialBundle:Grupa:change-parent.html.twig',['form' => $form->createView()]);
					}
				}else{
					$this->get('session')->getFlashBag()->add('error','Popraw formularz');
					$return = $this->render('PjplMaterialBundle:Grupa:change-parent.html.twig',['form' => $form->createView()]);
				}
			}else if($form->get('cancel')->isClicked()){
				$return = $this->render('PjplMaterialBundle:Grupa:list.html.twig',['grupa_array' => $this->get('material.grupa')->getArray()]);
			}else{
				$return = $this->render('PjplMaterialBundle:Grupa:change-parent.html.twig',['form' => $form->createView()]);
			}
		} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('error','Nieznany błąd');
				$return = $this->redirectToRoute('material_grupa');
		}
		return $return;
	}
}
