<?php
namespace Pjpl\MaterialBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Pjpl\MaterialBundle\Entity\Material;
/**
 * @ORM\Entity
 * @ORM\Table(name="jednostka_miary")
 */
class JednostkaMiary {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string", name="nazwa", unique=true, length=32, nullable=false)
	 */
	protected $nazwa;
	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string", name="skrot", unique=true, length=8, nullable=false)
	 */
	protected $skrot;
	/**
	 * @ORM\OneToMany(targetEntity="Material", mappedBy="jednostka_miary")
	 */
	protected $material;


	public function __construct() {
		$this->material = new ArrayCollection();
	}
	public function __toString() {
		return $this->nazwa.' ['.$this->skrot.']';
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
	public function getSkrot(){
		return $this->skrot;
	}
	public function setSkrot($skrot){
		$this->skrot = $skrot;
	}
	public function getMaterial(){
		return $this->material;
	}
	/**
	 * @param Material $material
	 * @return JednostkaMiary
	 */
	public function addMaterial(Material $material){
		$material->setJednostkaMiary($this);
		$this->material->add($material);
		return $this;
	}
}
