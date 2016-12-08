<?php
namespace Pjpl\MaterialBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pjpl\MaterialBundle\Entity\Material;
use Pjpl\MaterialBundle\Form\MaterialForm;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

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
						$this->get('session')->getFlashBag()->add('info', 'Dodano nowy materiał : '.$materialEntity);
						$return = $this->render('PjplMaterialBundle:Material:index.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
					} catch (UniqueConstraintViolationException $ex){
						$this->get('session')->getFlashBag()->add('error','Materiał jest już w bazie danych');
						$return = $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
					}
				}else{
					$this->get('session')->getFlashBag()->add('error','Popraw formularz');
					$return = $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
				}
			}else if($form->get('cancel')->isClicked()){
				$return = $this->render('PjplMaterialBundle:Material:index.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
			}else{
				$return = $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
			}
		} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('error','Nieznany błąd');
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
						$this->get('session')->getFlashBag()->add('info', 'Zmieniono wpis o materiale : '.$materialEntity);
						$return = $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
					} catch (UniqueConstraintViolationException $ex){
						$this->get('session')->getFlashBag()->add('error','Materiał jest już w bazie danych');
						$return = $this->render('PjplMaterialBundle:Material:edit.html.twig',['form' => $form->createView()]);
					}
				}else{
					$this->get('session')->getFlashBag()->add('error','Popraw formularz');
					$return = $this->render('PjplMaterialBundle:Material:add.html.twig',['form' => $form->createView()]);
				}
			}else if($form->get('cancel')->isClicked()){
				$return = $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
			}else{
				$return = $this->render('PjplMaterialBundle:Material:edit.html.twig',['form' => $form->createView()]);
			}
		} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('error','Nieznany błąd');
				$return = $this->redirectToRoute('material_material');
		}

		return $return;
	}
	public function deleteAction(Request $request, $id, $confirm = false){
		$return = $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);

		if($confirm){
			$em = $this->getDoctrine()->getManager();
			$materialRepo = $em->getRepository('PjplMaterialBundle:Material');
			try{
				$materialEntity = $materialRepo->find($id);
				$em->remove($materialEntity);
				$em->flush();
				$this->get('session')->getFlashBag()->add('info', 'Usunięto materiał : '.$materialEntity);
				$return = $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
			} catch (ForeignKeyConstraintViolationException $ex){
				$this->get('session')->getFlashBag()->add('error','Usunięcie materiału : "'.$materialEntity.'" jest niemożliwe ze względu na związanie relacjami z innymi rekordami.');
				$return = $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
			} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('error','Usunięcie materiału nie powiodoło sie z nieznanego powodu.');
				$return = $this->render('PjplMaterialBundle:Material:list.html.twig',['material_array' => $this->get('material.materialy')->getArray()]);
			}
		}else{
				$return = $this->render('PjplMaterialBundle:Material:list.html.twig',[
						'material_array' => $this->get('material.materialy')->getArray(),
						'delete_id' => $id
						]);
		}

		return $return;
	}

}