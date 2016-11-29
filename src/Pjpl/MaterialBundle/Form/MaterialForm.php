<?php
namespace Pjpl\MaterialBundle\Form;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MaterialForm extends AbstractType{
	public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
		$builder
				->add('nazwa', TextType::class,[
						'label'=> 'Nazwa materiału'
				])
				->add('kod', TextType::class,[
						'label'=> 'Kod materiału'
				])
				->add('jednostka_miary', EntityType::class, [
						'class' => 'Pjpl\MaterialBundle\Entity\JednostkaMiary',
						'placeholder' => 'Wybierz jm'
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
		public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
			$resolver->setDefaults(array(
					'data_class' => 'Pjpl\MaterialBundle\Entity\Material',
			));
			parent::configureOptions($resolver);
		}
}