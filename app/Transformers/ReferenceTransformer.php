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
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class ReferenceTransformer extends OrmTransformer {
    
    protected $defaultIncludes = [
        'parent',
        'contributors'
    ];
    
    public function transform(\App\Entities\Reference $reference)
    {
        return [
            'id' => $reference->getGuid(),
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
            'citation' => $reference->getCitation(),
            'citationHtml' => $reference->getCitationHtml()
        ];
    }
    
    public function includeParent(\App\Entities\Reference $reference)
    {
        $parent = $reference->getParent();
        if ($parent) {
            return new Fractal\Resource\Item($parent, new ReferenceTransformer, 'references');
        }
    }
    
    public function includeContributors(\App\Entities\Reference $reference)
    {
        $contributors = $reference->getContributors();
        if (count($contributors)) {
            return new Fractal\Resource\Collection($contributors, 
                    new ContributorTransformer, 'contributors');
        }
    }
}
