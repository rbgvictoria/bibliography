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

namespace App\Transformers;

/**
 * Description of AgentTransformer
 * 
 * @OA\Schema(
 *   schema="Agent",
 *   type="object"
 * )
 *
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class AgentTransformer extends OrmTransformer {
    
    protected $defaultIncludes = [
        'groupMembers'
    ];
    
    /**
     * @OA\Property(
     *   property="id",
     *   type="integer",
     *   format="int32"
     * ).
     * @OA\Property(
     *   property="type",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="name",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="lastName",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="initials",
     *   type="string"
     * ),
     *
     * @param \App\Entities\Agent $agent
     * @return array
     */
    public function transform(\App\Entities\Agent $agent)
    {
        return [
            'id' => $agent->getId(),
            'type' => $agent->getAgentType()->getName(),
            'name' => $agent->getName(),
            'lastName' => $agent->getLastName(),
            'firstName' => $agent->getFirstName(),
            'initials' => $agent->getInitials(),
        ];
    }
    
    /**
     * @OA\Property(
     *   property="groupMembers",
     *   type="array",
     *   @OA\Items(
     *     ref="#/components/schemas/GroupAgent"
     *   )
     * )
     * 
     * @param \App\Entities\Agent $agent
     * @return \League\Fractal\Resource\Collection
     */
    public function includeGroupMembers(\App\Entities\Agent $agent)
    {
        if ($agent->getAgentType() == $this->em
                ->getRepository('\App\Entities\AgentType')
                ->findOneBy(['name' => 'Group'])) {
            $members = $agent->getGroupMembers();
            if ($members) {
                return new \League\Fractal\Resource\Collection($agent
                        ->getGroupMembers(), new GroupAgentTransformer, 
                        'group-agents');
            }
        }
    }
}
