<?php
namespace Pjpl\MaterialBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pjpl\MaterialBundle\Entity\JednostkaMiary;
use Pjpl\MaterialBundle\Form\JednostkaMiaryForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class JednostkaMiaryController extends Controller{
	public function indexAction(){
		return $this->render('PjplMaterialBundle:JednostkaMiary:index.html.twig',['jm_array' => $this->get('material.jm')->getArray()]);
	}

	public function addAction(Request $request){
		$return = $this->redirectToRoute('material_jm');
		$jednostkaMiary = new JednostkaMiary();

		$form = $this->createForm(JednostkaMiaryForm::class, $jednostkaMiary);
		$form->handleRequest($request);

		try{
			if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){

				if($form->isValid()) {
					try{
						$jednostkaMiary = $form->getData();
						$em = $this->getDoctrine()->getManager();
						$em->persist($jednostkaMiary);
						$em->flush();
						$return = $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',['jm_array' => $this->get('material.jm')->getArray()]);
						$this->get('session')->getFlashBag()->add('info', 'Dodano nową jednostkę miary : '.$jednostkaMiary);
					} catch (UniqueConstraintViolationException $ex){
						$this->get('session')->getFlashBag()->add('error','Jednostka miary jest już w bazie danych');
						$return = $this->render('PjplMaterialBundle:JednostkaMiary:add.html.twig',['form' => $form->createView()]);
					}
				}else{
					$this->get('session')->getFlashBag()->add('error','Popraw formularz');
					$return = $this->render('PjplMaterialBundle:JednostkaMiary:add.html.twig',['form' => $form->createView()]);
				}
			}else if($form->get('cancel')->isClicked()){
				$return = $this->render('PjplMaterialBundle:JednostkaMiary:index.html.twig',['jm_array' => $this->get('material.jm')->getArray()]);
			}else{
				$return = $this->render('PjplMaterialBundle:JednostkaMiary:add.html.twig',['form' => $form->createView()]);
			}
		} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('error','Nieznany błąd');
				$return = $this->redirectToRoute('material_material');
		}

		return $return;
	}
	public function listAction(Request $request){
		return $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',['jm_array' => $this->get('material.jm')->getArray()]);
	}
	public function editAction(Request $request, $id){
		$return = $this->redirectToRoute('material_jm');
		$em = $this->container->get('doctrine')->getManager();
		$jmRepo = $em->getRepository('PjplMaterialBundle:JednostkaMiary');
		$jmEntity = $jmRepo->find($id);

		$form = $this->createForm(JednostkaMiaryForm::class, $jmEntity);
		$form->handleRequest($request);

		if ($form->isSubmitted() && !$form->get('cancel')->isClicked() ){
			if($form->isValid()) {
				try{
					$jmEntity = $form->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($jmEntity);
					$em->flush();
					$return = $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',['jm_array' => $this->get('material.jm')->getArray()]);
					$this->get('session')->getFlashBag()->add('info', 'Dokonano edycji jednostki miary : '.$jmEntity);
				} catch (UniqueConstraintViolationException $ex){
					$this->get('session')->getFlashBag()->add('error','Jednostka miary jest już w bazie danych');
					$return = $this->render('PjplMaterialBundle:JednostkaMiary:edit.html.twig',['form' => $form->createView()]);
				}
			}else{
				$this->get('session')->getFlashBag()->add('error','Popraw formularz');
				$return = $this->render('PjplMaterialBundle:JednostkaMiary:add.html.twig',['form' => $form->createView()]);
			}
		}else if($form->get('cancel')->isClicked()){
			$return = $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',['jm_array' => $this->get('material.jm')->getArray()]);
		}else{
			$return = $this->render('PjplMaterialBundle:JednostkaMiary:edit.html.twig',['form' => $form->createView()]);
		}
		return $return;
	}
	public function deleteAction(Request $request, $id, $confirm = false){
		$return = $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',['jm_array' => $this->get('material.jm')->getArray()]);

		try{

			if($confirm){
				$em = $this->getDoctrine()->getManager();
				$jmRepo = $em->getRepository('PjplMaterialBundle:JednostkaMiary');
				$jmEntity = $jmRepo->find($id);
				try{
					$em->remove($jmEntity);
					$em->flush();
					$this->get('session')->getFlashBag()->add('info', 'Usunięto jednoskę miary : '.$jmEntity);
					$return = $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',['jm_array' => $this->get('material.jm')->getArray()]);
				} catch (ForeignKeyConstraintViolationException $ex){
					$this->get('session')->getFlashBag()->add('error','Usunięcie jednostki miary : "'.$jmEntity->getNazwa().'" jest niemożliwe ze względu na związanie relacjami z innymi rekordami.');
					$return = $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',[
							'jm_array' => $this->get('material.jm')->getArray(),
							]);
				} catch (\Exception $ex) {
					$this->get('session')->getFlashBag()->add('error','Usunięcie jednostki miary : "'.$jmEntity->getNazwa().'" nie powiodoło sie z nieznanego powodu.');
					$return = $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',[
							'jm_array' => $this->get('material.jm')->getArray(),
							]);
				}
			}else{
					$return = $this->render('PjplMaterialBundle:JednostkaMiary:list.html.twig',[
							'jm_array' => $this->get('material.jm')->getArray(),
							'delete_id' => $id
							]);
			}

		} catch (\Exception $ex) {
				$this->get('session')->getFlashBag()->add('error','Nieznany błąd');
				$return = $this->redirectToRoute('material_material');
		}

		return $return;
	}
}