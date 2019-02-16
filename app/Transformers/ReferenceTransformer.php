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

use League\Fractal;

/**
 * Description of ReferenceTransformer
 *
 * @OA\Schema(
 *   schema="Reference",
 *   type="object"
 * )
 * 
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class ReferenceTransformer extends OrmTransformer {
    
    protected $defaultIncludes = [
        'author',
        'parent',
    ];
    
    /**
     * @OA\Property(
     *   property="id",
     *   type="integer",
     *   format="int32"
     * ),
     * @OA\Property(
     *   property="type",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="publicationYear",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="title",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="volume",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="issue",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="number",
     *   type="integer",
     *   format="int32"
     * ),
     * @OA\Property(
     *   property="pageStart",
     *   type="integer",
     *   format="int32"
     * ),
     * @OA\Property(
     *   property="pageEnd",
     *   type="integer",
     *   format="int32"
     * ),
     * @OA\Property(
     *   property="numberOfPages",
     *   type="integer",
     *   format="int32"
     * ),
     * @OA\Property(
     *   property="publisher",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="placeOfPublication",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="citation",
     *   type="string"
     * ),
     * @OA\Property(
     *   property="citationHtml",
     *   type="string"
     * )
     *
     * @param \App\Entities\Reference $reference
     * @return array
     */
    public function transform(\App\Entities\Reference $reference)
    {
        return [
            'id' => $reference->getId(),
            'type' => $reference->getReferenceType()->getName(),
            'publicationYear' => $reference->getPublicationYear(),
            'title' => $reference->getTitle(),
            'volume' => $reference->getVolume(),
            'issue' => $reference->getIssue(),
            'number' => $reference->getNumber(),
            'pageStart' => $reference->getPageStart(),
            'pageEnd' => $reference->getPageEnd(),
            'pages' => $reference->getPages(),
            'numberOfPages' => $reference->getNumberOfPages(),
            'publisher' => $reference->getPublisher(),
            'placeOfPublication' => $reference->getPlaceOfPublication(),
            'isbn' => $reference->getIsbn(),
            'issn' => $reference->getIssn(),
            'doi' => $reference->getDoi(),
            'citation' => $reference->getCitation(),
            'citationHtml' => $reference->getCitationHtml()
        ];
    }

    /**
     * @OA\Property(
     *   property="author",
     *   ref="#/components/schemas/Agent"
     * )
     *
     * @param \App\Entities\Reference $reference
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor(\App\Entities\Reference $reference)
    {
        $author = $reference->getAuthor();
        if ($author) {
            return new Fractal\Resource\Item($author, new AgentTransformer, 'agents');
        }
    }
    
    /**
     *  @OA\Property(
     *    property="parent",
     *    ref="#/components/schemas/Reference"
     *  )
     *
     * @param \App\Entities\Reference $reference
     * @return \League\Fractal\Resource\Item
     */
    public function includeParent(\App\Entities\Reference $reference)
    {
        $parent = $reference->getParent();
        if ($parent) {
            return new Fractal\Resource\Item($parent, new ReferenceTransformer, 'references');
        }
    }
}
