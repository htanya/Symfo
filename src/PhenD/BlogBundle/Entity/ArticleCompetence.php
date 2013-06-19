<?php
// src/PhenD/BlogBundle/Entity/ArticleCompetence.php
 
namespace PhenD\BlogBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity
 */
class ArticleCompetence
{
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="PhenD\BlogBundle\Entity\Article")
   */
  private $article;
 
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="PhenD\BlogBundle\Entity\Competence")
   */
  private $competence;
 
  /**
   * @ORM\Column()
   */
  private $niveau; // Ici j'ai un attribut de relation, que j'ai appelé « niveau »
 
  /**
   * @param string $niveau
   * @return Article_Competence
   */
  public function setNiveau($niveau)
  {
    $this->niveau = $niveau;
    return $this;
  }
 
  /**
   * @return string
   */
  public function getNiveau()
  {
    return $this->niveau;
  }
 
  /**
   * @param PhenD\BlogBundle\Entity\Article $article
   * @return ArticleCompetence
   */
  public function setArticle(\PhenD\BlogBundle\Entity\Article $article)
  {
    $this->article = $article;
    return $this;
  }
 
  /**
   * @return PhenD\BlogBundle\Entity\Article
   */
  public function getArticle()
  {
    return $this->article;
  }
 
  /**
   * @param PhenD\BlogBundle\Entity\Competence $competence
   * @return ArticleCompetence
   */
  public function setCompetence(\PhenD\BlogBundle\Entity\Competence $competence)
  {
    $this->competence = $competence;
    return $this;
  }
 
  /**
   * @return PhenD\BlogBundle\Entity\Competence
   */
  public function getCompetence()
  {
    return $this->competence;
  }
}
