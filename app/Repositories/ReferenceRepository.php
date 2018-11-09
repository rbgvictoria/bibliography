<?php

namespace App\Repositories;

/**
 * ReferenceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReferenceRepository extends \Doctrine\ORM\EntityRepository
{
    public function getContributorString(\App\Entities\Reference $ref)
    {
        return $ref->getContributors()->map(function($contributor) {
            return $contributor->getAgent->getName();
        });
    }
}
