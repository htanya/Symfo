<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;
use Phenome\TryBundle\Query;
use Phenome\TryBundle\Twig;

//use Phenome\TryBundle\Entity\Drug;

/*
$container->setDefinition(
    'remove.slashes',
    new Definition(
        'Phenome\TryBundle\Query\checkaddslashes'/*,
        array(
            new Reference('service_id'),
            "plain_value",/*
            new Parameter('parameter_name'), 
        )  */ /*
    ) 
); */


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

$container
    ->register('phenome.twig.replacedrug_extension', 'Phenome\TryBundle\Twig\ReplacedrugExtension')
    ->addTag('twig.extension');

$container
    ->register('phenome.twig.replacetarget_extension', 'Phenome\TryBundle\Twig\ReplacetargetExtension')
    ->addTag('twig.extension');

$container
    ->register('phenome.twig.urlencode_extension', 'Phenome\TryBundle\Twig\URLencodeExtension')
    ->addTag('twig.extension');

$container
    ->register('phenome.twig.getTargetID_extension', 'Phenome\TryBundle\Twig\GetTargetID')
    ->addTag('twig.extension');

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
