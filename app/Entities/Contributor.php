<?php

/*
 * Copyright 2018 Royal Botanic Gardens Victoria.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Author
 * 
 * @ORM\Entity()
 * @ORM\Table(indexes={@ORM\Index(name="contributors_sequence_idx", columns={"sequence"})})
 *
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class Contributor extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Reference", inversedBy="contributors")
     * @ORM\JoinColumn(name="reference_id", referencedColumnName="id", nullable=false)
     * @var \App\Entities\Reference
     */
    protected $reference;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=false)
     * @var \App\Entities\Agent
     */
    protected $agent;
    
    /**
     * @ORM\ManyToOne(targetEntity="ContributorRole")
     * @ORM\JoinColumn(name="contributor_role_id", referencedColumnName="id", nullable=false)
     * @var \App\Entities\ContributorRole
     */
    protected $contributorRole;
    
    /**
     * @ORM\Column(type="smallint")
     * @var int
     */
    protected $sequence;
    
    /**
     * 
     * @return \App\Entities\Reference
     */
    public function getReference()
    {
        return $this->reference;
    }
    
    /**
     * 
     * @param \App\Entities\Reference $reference
     */
    public function setReference(Reference $reference)
    {
        $this->reference = $reference;
    }
    
    /**
     * 
     * @return \App\Entities\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }
    
    /**
     * 
     * @param \App\Entities\Agent $agent
     */
    public function setAgent(Agent $agent)
    {
        $this->agent = $agent;
    }
    
    /**
     * 
     * @return \App\Entities\ContributorRole
     */
    public function getContributorRole()
    {
        return $this->contributorRole;
    }
    
    /**
     * 
     * @param \App\Entities\ContributorRole $role
     */
    public function setContributorRole(ContributorRole $role)
    {
        $this->contributorRole = $role;
    }
    
    /**
     * 
     * @return int
     */
    public function getSequence()
    {
        return $this->sequence;
    }
    
    /**
     * 
     * @param int $sequence
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }
}
