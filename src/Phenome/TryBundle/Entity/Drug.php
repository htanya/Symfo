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

/*
public function setDrug($drug)
	{
		$this->drug = $drug;
	}

	public function getDrug ()
	{
		return $this->drug;
	} */


 public function __toString()
    {
        return strval($this->drugname);
    }
	


}//closes class
