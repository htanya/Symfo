<?php
// src/PhenD/BlogBundle/Antispam/PhenDAntispam.php
 
namespace PhenD\BlogBundle\Antispam;
 
class PhenDAntispam
{
  protected $mailer;
  protected $locale;
  protected $nbForSpam;
 
  public function __construct(\Swift_Mailer $mailer, $locale, $nbForSpam)
  {
    $this->mailer    = $mailer;
    $this->locale    = $locale;
    $this->nbForSpam = (int) $nbForSpam;
  }
 
  /**
   * Vérifie si le texte est un spam ou non
   * Un texte est considéré comme spam à partir de 3 liens
   * ou adresses e-mails dans son contenu
   *
   * @param string $text
   */
  public function isSpam($text)
  {
    // On utilise maintenant l'argument $this->nbForSpam et non plus le « 3 » en dur :
    return ($this->countLinks($text) + $this->countMails($text)) >= $this->nbForSpam;
  }
 
  // … on pourrait également utiliser $this->mailer pour prévenir d'un spam l'administrateur par exemple
}
