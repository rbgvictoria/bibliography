<?php

/*
 * Copyright 2019 Royal Botanic Gardens Victoria.
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

namespace App\Transformers;

use League\Fractal;

/**
 * Description of GroupAgentTransformer
 * 
 * @OA\Schema(
 *   schema="GroupAgent",
 *   type="object",
 *   required={"sequence", "member"}
 * )
 *
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class GroupAgentTransformer extends OrmTransformer {
    
    protected $availableIncludes = [
        'group'
    ];
    
    protected $defaultIncludes = [
        'member'
    ];
    
    /**
     * @OA\Property(
     *   property="id",
     *   type="integer",
     *   format="int32"
     * ),
     * @OA\Property(
     *   property="sequence",
     *   type="integer",
     *   format="int32"
     * )
     * 
     * @param \App\Entities\GroupAgent $groupAgent
     * @return array
     */
    public function transform(\App\Entities\GroupAgent $groupAgent)
    {
        return [
            'id' => $groupAgent->getId(),
            'sequence' => $groupAgent->getSequence()
        ];
    }
    
    /**
     * @OA\Property(
     *   property="group",
     *   ref="#/components/schemas/Agent"
     * )
     * 
     * @param \App\Entities\GroupAgent $groupAgent
     * @return \League\Fractal\Resource\Item
     */
    public function includeGroup(\App\Entities\GroupAgent $groupAgent)
    {
        return new Fractal\Resource\Item($groupAgent->getGroup(), 
                new AgentTransformer, 'agents');
    }
    
    /**
     * @OA\Property(
     *   property="member",
     *   ref="#/components/schemas/Agent"
     * )
     * 
     * @param \App\Entities\GroupAgent $groupAgent
     * @return \League\Fractal\Resource\Item
     */
    public function includeMember(\App\Entities\GroupAgent $groupAgent) 
    {
        return new Fractal\Resource\Item($groupAgent->getMember(), 
                new AgentTransformer, 'agents');
    }
}
