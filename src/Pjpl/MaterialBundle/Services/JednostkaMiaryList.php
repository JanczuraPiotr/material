<?php
namespace Pjpl\MaterialBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Zestawieni jednostek miary
 */
class JednostkaMiaryList {
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
		$materialRepo = $this->em->getRepository('PjplMaterialBundle:JednostkaMiary');
		$arr = $materialRepo->findAll();
		return $arr;
	}
}