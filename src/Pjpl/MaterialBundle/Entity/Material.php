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
	 * @Assert\Length(
	 *		min = 2,
	 *		minMessage = "Za krótki kod materiału"
	 * )
	 * @ORM\Column(type="string", name="kod", unique=true, length=16, nullable=false)
	 */
	protected $kod;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Length(
	 *		min = 3,
	 *		minMessage = "Za krótka nazwa materiału"
	 * )
	 * @ORM\Column(type="string", name="nazwa", unique=true, length=64, nullable=false)
	 */
	protected $nazwa;
	/**
	 * @ORM\ManyToOne(targetEntity="JednostkaMiary", inversedBy="material")
	 * @ORM\JoinColumn(name="jednostka_miary_id", referencedColumnName="id", nullable=false)
	 */
	protected $jednostka_miary;
	/**
	 * @ORM\ManyToOne(targetEntity="GrupaMaterialow", inversedBy="material")
	 * @ORM\JoinColumn(name="grupa_materialow_id", referencedColumnName="id", nullable=false)
	 */
	protected $grupa_materialow;

	public function __toString() {
		return $this->getNazwa().' [skrót :  '.$this->getKod().']';
	}
	/**
	 *
	 * @return int
	 */
	public function getId(){
		return $this->id;
	}
	/**
	 * @param string $kod
	 */
	public function setKod($kod){
		$this->kod = $kod;
	}
	/**
	 * @return string
	 */
	public function getKod(){
		return $this->kod;
	}
	/**
	 * @param string $nazwa
	 */
	public function setNazwa($nazwa){
		$this->nazwa = $nazwa;
	}
	/**
	 * @return string
	 */
	public function getNazwa(){
		return $this->nazwa;
	}
	/**
	 * @return GrupaMaterialow
	 */
	public function getGrupaMaterialow(){
		return $this->grupa_materialow;
	}
	public function setGrupaMaterialow(GrupaMaterialow $grupaMamerialow){
		$this->grupa_materialow = $grupaMamerialow;
	}
	/**
	 * @return JednostkaMiary
	 */
	public function getJednostkaMiary(){
		return $this->jednostka_miary;
	}
	public function setJednostkaMiary(JednostkaMiary $jednostkaMiary){
		$this->jednostka_miary = $jednostkaMiary;
	}

}
