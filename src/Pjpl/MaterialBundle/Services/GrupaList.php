<?php
namespace Pjpl\MaterialBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Zestawieni grup materiałów
 */
class GrupaList {
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
		$materialRepo = $this->em->getRepository('PjplMaterialBundle:GrupaMaterialow');
		$arr = $materialRepo->findAll();
		return $arr;
	}
}