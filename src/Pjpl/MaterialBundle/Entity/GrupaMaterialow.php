<?php
namespace Pjpl\MaterialBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
	
/**
 * @ORM\Entity
 * @ORM\Table(name="grupa_materialow")
 * @ORM\Entity(repositoryClass="Pjpl\MaterialBundle\Entity\GrupaMaterialowRepository")
 */
class GrupaMaterialow {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string", name="name", unique=true, length=64, nullable=false)
	 */
	protected $name;
	/**
	 * @ORM\ManyToOne(targetEntity="GrupaMaterialow", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	protected $parent;
	/**
	 * @ORM\OneToMany(targetEntity="GrupaMaterialow", mappedBy="parent")
	 * @ORM\JoinColumn(name="id", referencedColumnName="parent_id")
	 */
	protected $children;

	public function __construct() {
		$this->children = new ArrayCollection();
	}

	public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function setName($name){
		$this->name = $name;
	}
	public function setParent(GrupaMaterialow $parent){
		$this->parent = $parent;
	}
	public function getParent(){
		return $this->parent;
	}
	public function addChild(GrupaMaterialow $child){
		$child->setParent($this);
		$this->children->add($child);
	}
	public function setChildren(array $children){
		$this->children = $children;
		foreach ($children as $child){
			$child->setParent($this);
		}
	}
	/**
	 * @return PersistentCollection
	 */
	public function getChildren(){
		return $this->children;
	}
}