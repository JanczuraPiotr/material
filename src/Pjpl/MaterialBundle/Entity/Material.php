<?php
namespace Pjpl\MaterialBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="material")
 * @ORM\Entity(repositoryClass="Pjpl\MaterialBundle\Entity\MaterialyRepository")
 */
class Material{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string", name="kod", unique=true, length=16, nullable=false)
	 */
	protected $kod;
	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string", name="nazwa", unique=true, length=64, nullable=false)
	 */
	protected $nazwa;
	/**
	 * @ORM\ManyToOne(targetEntity="JednostkaMiary", inversedBy="material")
	 * @ORM\JoinColumn(name="jednostka_miary_id", referencedColumnName="id", nullable=false)
	 */
	protected $jednostka_miary;

	public function __toString() {
		return $this->getNazwa().' ['.$this->getKod().']';
	}

	public function getId(){
		return $this->id;
	}

	public function setKod($kod){
		$this->kod = $kod;
	}
	public function getKod(){
		return $this->kod;
	}
	public function setNazwa($nazwa){
		$this->nazwa = $nazwa;
	}
	public function getNazwa(){
		return $this->nazwa;
	}
	public function getJednostkaMiary(){
		return $this->jednostka_miary;
	}
	public function setJednostkaMiary($jednostkaMiary){
		$this->jednostka_miary = $jednostkaMiary;
	}

}
