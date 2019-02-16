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
 * Description of CitationTransformer
 * 
 * @OA\Schema(
 *   schema="Citation",
 *   type="object"
 * )
 *
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class CitationTransformer extends OrmTransformer {
    
    /**
     * @OA\Property(
     *   property="id",
     *   type="integer",
     *   format="int32"
     * ),
     * @OA\Property(
     *   property="referenceType",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="author",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="year",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="citation",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="citationHtml",
     *   type="string"
     * ),
     *
     * @param \App\Entities\Reference $ref
     * @return array
     */
    public function transform(\App\Entities\Reference $ref)
    {
        return [
            'id' => $ref->getId(),
            'referenceType' => $ref->getReferenceType()->getName(),
            'author' => $ref->getAuthor()->getName(),
            'year' => $ref->getPublicationYear(),
            'citation' => $ref->getCitation(),
            'citationHtml' => $ref->getCitationHtml()
        ];
    }
}