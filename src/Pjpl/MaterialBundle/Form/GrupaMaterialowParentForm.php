<?php
namespace Pjpl\MaterialBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GrupaMaterialowParentForm extends AbstractType{
	public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
		$builder
				->add('nazwa', TextType::class,[
					'label'=> 'Nazwa kategorii',
					'disabled' => true,
				])
				->add('parent', EntityType::class, [
						'label' => 'Grupa nadrzędna',
						'class' => 'Pjpl\MaterialBundle\Entity\GrupaMaterialow',
						'placeholder' => 'Bez grupy nadrzędnej',
						'required'=> false,
				])
				->add('zatwierdz', SubmitType::class,[
					'label' => 'Zatwierdź'
				])
				->add('cancel', SubmitType::class,[
					'label'=>'Rezygnuję',
					'attr'=> [
							'formnovalidate'=>'formnovalidate'
					]
				]);
	}
}