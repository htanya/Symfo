<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;
use Phenome\TryBundle\Query;

//use Phenome\TryBundle\Entity\Drug;

$container->setDefinition(
    'phenome_try.query',
    new Definition(
        'Phenome\TryBundle\Query\getDrugQuery'/*,
        array(
            new Reference('service_id'),
            "plain_value",/*
            new Parameter('parameter_name'), 
        )  */
    ) 
);

//$container->setParameter('DrugRepository.class', 'getDrugQuery');

/*
$container->setParameter('DrugRepository.class', 'getDrugQuery');
/*
$container->setParameter('DrugRepository.transport', 'getDrugsQuery');

$container->setDefinition('DrugRepository', new Definition(
    '%DrugRepository.class%')
);
*/

/*

$container->setDefinition(
    'phenome_try.example',
    new Definition(
        'Phenome\TryBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);

*/
