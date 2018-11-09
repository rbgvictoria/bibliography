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
 * Description of ReferenceType
 * 
 * @ORM\Entity()
 * @ORM\Table()
 *
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class ReferenceType extends Vocab {
    
    /**
     * @ORM\ManyToOne(targetEntity="ReferenceType")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @var \App\Entities\ReferenceType
     */
    protected $parent;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $parentIsOptional;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $useParentDetails;
    
    /**
     * 
     * @return \App\Entities\RelationshipType
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * 
     * @param \App\Entities\RelationshipType $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
    
    /**
     * 
     * @return bool
     */
    public function getParentIsOptional()
    {
        return $this->parentIsOptional;
    }
    
    /**
     * 
     * @param bool $parentIsOptional
     */
    public function setParentIsOptional($parentIsOptional)
    {
        $this->parentIsOptional = $parentIsOptional;
    }
    
    /**
     * 
     * @return bool
     */
    public function getUseParentDetails()
    {
        return $this->useParentDetails;
    }
    
    /**
     * 
     * @param bool $useParentDetails
     */
    public function setUseParentDetails($useParentDetails)
    {
        $this->useParentDetails = $useParentDetails;
    }
}
