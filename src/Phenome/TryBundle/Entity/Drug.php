<?php

namespace Phenome\TryBundle\Entity;

/**
 * Phenome\TryBundle\Entity\Drug
 *
 * \Entity(repositoryClass="Phenome\TryBundle\Entity\DrugRepository")
 */



class Drug
{
	private $drugname = null;

	public function setDrugname($drugname)
	{
		$this->drugname = $drugname;
	}
	public function getDrugname()
	{
		return $this->drugname;
	}


public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
{
    $this->container = $container;
}

}
