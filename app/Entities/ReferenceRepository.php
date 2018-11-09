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

use App\Entities\Reference;
use Doctrine\ORM\EntityRepository;

/**
 * Description of ReferenceRepository
 *
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class ReferenceRepository extends EntityRepository {
    
    /**
     * 
     * @param \App\Entities\Reference $ref
     * @return array
     */
    public function getContributorString(\App\Entities\Reference $ref)
    {
        $dql = "SELECT a.name, cr.name as role "
                . "FROM \App\Entities\Reference r "
                . "JOIN r.contributors c "
                . "JOIN c.contributorRole cr "
                . "JOIN c.agent a "
                . "WHERE r.id=:ref "
                . "ORDER BY c.sequence";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('ref', $ref);
        $contributors = $query->getArrayResult();
        $str = str_replace_last('; ', ' & ', implode('; ', array_map(function($item) {
            return $item['name'];
        }, $contributors)));
        if ($contributors && $contributors[0]['role'] == 'Editor') {
            if (count($contributors) == 1) {
                $str .= ' (ed.)';
            }
            else {
                $str .= ' (eds)';
            }
        }
        return $str;
    }
    
    public function getReferenceString(\App\Entities\Reference $ref)
    {
        $type = $ref->getReferenceType()->getName();
        $author = $ref->getContributorsCache();
        $str = '';
        switch ($type) {
            case 'Journal':
            case 'Series':    
                $str .= $ref->getTitle();
                break;
            
            case 'Book':
            case 'Report':
            case 'AudioVisualDocument':
                $str .= '**' . $author . ' (' . $ref->getPublicationYear() . ')**. *&zwj;' . $ref->getTitle() . '&zwj;*.';
                if ($ref->getPublisher()) {
                    $str .= ' ' . $ref->getPublisher();
                    if ($ref->getPlaceOfPublication()) {
                        $str .= ', ' . $ref->getPlaceOfPublication();
                    }
                    $str .= '.';
                }
                break;
                
            case 'Article':
                $str .= '**' . $author . ' (' . $ref->getPublicationYear() . ')**. ' . $ref->getTitle() . '. ';
                $str .= '*' . $ref->getParent()->getTitle() . '*';
                if ($ref->getVolume()) {
                    $str .= ' **' . $ref->getVolume() . '**';
                    if ($ref->getIssue()) {
                        $str .= '(' . $ref->getIssue() . ')';
                    }
                    if ($ref->getPageStart()) {
                        $str .= ': ' . $ref->getPageStart() . '–' . $ref->getPageEnd();
                    }
                    elseif($ref->getPages()) {
                        $str .= ': ' . $ref->getPages();
                    }
                }
                elseif($ref->getNumber()) {
                    $str .= ' ' . $ref->getNumber();
                }
                $str .= '.';
                break;
                
            case 'Chapter': 
                $str .= '**' . $author . ' (' . $ref->getPublicationYear() . ')**. ' . $ref->getTitle() . '. ';
                $str .= 'In: ' . $ref->getParent()->getContributorsCache()
                        . ', *&zwj;' . $ref->getParent()->getTitle() . '&zwj;*'
                        . ', pp. ' . $ref->getPageStart() . '–' . $ref->getPageEnd() 
                        . '. ';
                if ($ref->getParent()->getPublisher()) {
                    $str .= ' ' . $ref->getParent()->getPublisher();
                    if ($ref->getParent()->getPlaceOfPublication()) {
                        $str .= ', ' . $ref->getParent()->getPlaceOfPublication();
                    }
                    $str .= '.';
                }
                break;

            default:
                break;
        }
        return $str;
    }
}
