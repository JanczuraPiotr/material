<?php
namespace Pjpl\MaterialBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MaterialList {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
		$this->em = $this->container->get('doctrine')->getManager();
	}
	public function getArray(){
		$materialRepo = $this->em->getRepository('PjplMaterialBundle:Materialy');
		$arr = $materialRepo->findAll();
		return $arr;
	}
}