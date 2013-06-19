<?php
// src/PhenD/BlogBundle/Entity/Categorie.php
 
namespace PhenD\BlogBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PhenD\BlogBundle\Entity\CategorieRepository")
 */
class Categorie
{
  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
 
  /**
   * @var string $nom
   *
   * @ORM\Column(name="nom", type="string", length=255)
   */
  private $nom;
 
 
  /**
   * @return integer 
   */
  public function getId()
  {
    return $this->id;
  }
 
  /**
   * @param string $nom
   * @return Categorie
   */
  public function setNom($nom)
  {
    $this->nom = $nom;
    return $this;
  }
 
  /**
   * @return string 
   */
  public function getNom()
  {
    return $this->nom;
  }
}
