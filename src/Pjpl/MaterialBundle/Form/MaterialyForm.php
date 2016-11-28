<?php
namespace Pjpl\MaterialBundle\Form;
use Symfony\Component\Form\AbstractType;

class MaterialyForm extends AbstractType{
	public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
		$builder
				->add('nazwa', 'text',[
					'label'=> 'Nazwa materiału'
				])
				->add('kod', 'text',[
					'label'=> 'Kod materiału'
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