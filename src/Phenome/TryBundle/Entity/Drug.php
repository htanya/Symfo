<?php

namespace Phenome\TryBundle\Entity;

/**
 * Phenome\TryBundle\Entity\Drug
 *
 * 
 */



class Drug
{

	private $drugname = null;
	private $drug = null;
	


	public function setDrugname()
	{
		$this->drugname = $drugname;
	}

	public function getDrugname ()
	{
		return $this->drugname;
	}


public function setDrug_uri()
	{
		$this->drug_uri = $drug_uri;
	}

	public function getDrug_uri ()
	{
		return $this->drug_uri;
	} 


 public function __toString()
    {
        return strval($this->drugname);
    }
	


}//closes class
