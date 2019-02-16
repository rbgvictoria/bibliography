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

namespace App\Repositories;

use App\Entities\Reference;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;
use Doctrine\ORM\QueryBuilder;

/**
 * Description of ImageRepository
 *
 * @author nklazenga
 */
class ReferenceRepository extends EntityRepository {
    
    use PaginatesFromParams;
    
    protected $parameters;
    
    /**
     * 
     * @param \App\Entities\Reference $ref
     * @return array
     */
    public function getContributorString(Reference $ref)
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
    
    public function getReferenceString(Reference $ref)
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
    
    /**
     * 
     * @param array $params
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator|array
     */
    public function getCitations($params, $perPage=20, $page=1)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')->from('\App\Entities\Reference', 'r')
                ->join('r.referenceType', 'rt')
                ->leftJoin('r.author', 'a');
        $this->parameters = [];
        if (isset($params['filter'])) {
            $qb = $this->searchCriteria($qb, $params['filter']);
        }
        $qb->addOrderBy('a.name');
        $qb->addOrderBy('r.publicationYear');
        $query = $qb->getQuery();
        if ($this->parameters) {
            $query->setParameters($this->parameters);
        }
        if (!$perPage) {
            return $query->getResult();
        }
        return $this->paginate($query, $perPage, $page);
    }
    
    protected function searchCriteria(QueryBuilder $qb, $filters)
    {
        if (isset($filters['author'])) {
            $qb->andWhere($qb->expr()->like('a.name', ':author'));
            $this->parameters['author'] = $filters['author'] . '%';
        }
        if (isset($filters['year'])) {
            $qb->andWhere($qb->expr()->eq('r.publicationYear', ':year'));
            $this->parameters['year'] = $filters['year'];
        }
        if (isset($filters['type'])) {
            $qb->andWhere($qb->expr()->in('rt.name', ':type'));
            $this->parameters['type'] = (strpos($filters['type'], ',') !== false) 
                    ? preg_split('/, ?/', $filters['type']) : $filters['type'];
        }
        return $qb;
    }
    
    public function searchTitle($title, $type=null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')
                ->from('\App\Entities\Reference', 'r')
                ->andWhere($qb->expr()->like('r.title', ':title'))
                ->orderBy('r.title');
        $params = [
            'title' => $title . '%'
        ];
        if ($type) {
            $qb->join('r.referenceType', 'ty')
                    ->andWhere($qb->expr()->in('ty.name', ':type'));
            $params['type'] = $type;
        }
        $query = $qb->getQuery();
        $query->setParameters($params);
        return $query->getResult();
    }
}
