<?php
namespace Pjpl\MaterialBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Pjpl\MaterialBundle\Entity\Material;
use Pjpl\MaterialBundle\Entity\GrupaMaterialow;

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
	 * @Assert\NotBlank(
	 *		message = "Musisz podać nazwę"
	 * )
	 * @Assert\Length(
	 *		min = 3,
	 *		minMessage = "Za krótka nazwa grupy materiału"
	 *	)
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
	/**
	 * @ORM\OneToMany(targetEntity="Material", mappedBy="grupa_materialow")
	 */
	protected $material;

	public function __construct() {
		$this->children = new ArrayCollection();
		$this->material = new ArrayCollection();
	}
	public function __toString() {
		return $this->getNazwa().( $this->getParent() ? ' [ należy do grupy : '.$this->getParent()->getNazwa().']' : '');
	}
	/**
	 * @return int
	 */
	public function getId(){
		return $this->id;
	}
	/**
	 * @return string
	 */
	public function getNazwa(){
		return $this->nazwa;
	}
	/**
	 * @param string $nazwa
	 * @return GrupaMaterialow
	 */
	public function setNazwa($nazwa){
		$this->nazwa = $nazwa;
		return $this;
	}
	/**
	 * @param Material $material
	 * @return GrupaMaterialow
	 */
	public function addMaterial(Material $material){
		$material->setGrupaMaterialow($this);
		$this->material->add($material);
		return $this;
	}
	/**
	 * @return Material
	 */
	public function getMaterial(){
		return $this->material;
	}
	/**
	 * @param GrupaMaterialow $parent
	 * @return GrupaMaterialow
	 */
	public function setParent(GrupaMaterialow $parent = null){
		$this->parent = $parent;
		return $this;
	}
	/**
	 * @return GrupaMaterialow
	 */
	public function getParent(){
		return $this->parent;
	}
	/**
	 * @param GrupaMaterialow $child
	 * @return GrupaMaterialow
	 */
	public function addChild(GrupaMaterialow $child = null){
		$child->setParent($this);
		$this->children->add($child);
		return $this;
	}
	/**
	 * @param array $children
	 * @return GrupaMaterialow
	 */
	public function setChildren(array $children){
		$this->children = $children;
		foreach ($children as $child){
			$child->setParent($this);
		}
		return $this;
	}
	/**
	 * @return PersistentCollection
	 */
	public function getChildren(){
		return $this->children;
	}
	/**
	 * @param GrupaMaterialow $child
	 * @return GrupaMaterialow
	 */
	public function removeChild(GrupaMaterialow $child){
		$this->children->removeElement($child);
		return $this;
	}
}
