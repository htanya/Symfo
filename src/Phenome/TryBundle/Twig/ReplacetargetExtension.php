<?php
// src/Phenome/TryBundle/Twig/RemoveTargetPath.php
namespace Phenome\TryBundle\Twig;



class ReplacetargetExtension extends \Twig_Extension
{

public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('removeTargetPath', array($this, 'removeTargetPathFilter')),
        );
}//closes function

    public function removeTargetPathFilter($text)
	{
$search= '';
$search = '/http.+target\//';
    // replace non letter or digits by -
    		$text = preg_replace($search, '', $text);
		return $text;
	} //closes function

 public function getName()
    {
        return 'removeTargetPath_extension';
    }

} //closes class

