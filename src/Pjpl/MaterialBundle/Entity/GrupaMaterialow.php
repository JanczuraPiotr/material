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
	 * @ORM\Column(type="string", name="nazwa", unique=true, length=64, nullable=false)
	 */
	protected $nazwa;
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
	public function __toString() {
		return $this->getNazwa().( $this->getParent() ? ' [ należy do grupy : '.$this->getParent()->getNazwa().']' : '');
	}

	public function getId(){
		return $this->id;
	}
	public function getNazwa(){
		return $this->nazwa;
	}
	public function setNazwa($nazwa){
		$this->nazwa = $nazwa;
	}
	public function setParent(GrupaMaterialow $parent = null){
		$this->parent = $parent;
	}
	/**
	 * @return GrupaMaterialow
	 */
	public function getParent(){
		return $this->parent;
	}
	public function addChild(GrupaMaterialow $child = null){
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
	/**
	 * @param \Pjpl\MaterialBundle\Entity\GrupaMaterialow $child
	 */
	public function removeChild(\Pjpl\MaterialBundle\Entity\GrupaMaterialow $child){
		$this->children->removeElement($child);
	}
}
