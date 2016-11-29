<?php
namespace Pjpl\MaterialBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JednostkaMiaryForm extends AbstractType{
	public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
		$builder
				->add('nazwa', TextType::class,[
					'label'=> 'Nazwa'
				])
				->add('skrot', TextType::class,[
					'label'=> 'Skrót'
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