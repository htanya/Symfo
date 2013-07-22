<?php
// src/Phenome/TryBundle/Twig/MatchExtension.php
namespace Phenome\TryBundle\Twig;



class MatchExtension extends \Twig_Extension
{

    public function matchValue($array, $value)
	{
  if(is_array($array) && count($array)>0) 
        {
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];
                
                if ($temp[$key] == $value){
                    $newarray[$key] = $array[$key];
                }
            }
          }
      return $newarray;
    
	} //closes function

 public function getName()
    {
        return 'match_extension';
    }

} //closes class

