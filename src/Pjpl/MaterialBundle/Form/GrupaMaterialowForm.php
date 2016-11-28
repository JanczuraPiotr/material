<?php
namespace Pjpl\MaterialBundle\Form;
use Symfony\Component\Form\AbstractType;

class GrupaMaterialowForm extends AbstractType{
	public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
		$builder
				->add('name', 'text',[
					'label'=> 'Nazwa kategorii'
				])
				->add('zatwierdz','submit',[
					'label' => 'Zatwierdź'
				])
				->add('cancel','submit',[
					'label'=>'Rezygnuję',
					'attr'=> [
							'formnovalidate'=>'formnovalidate'
					],
					'validation_groups' => false
				]);
	}
}