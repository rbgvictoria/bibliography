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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Reference
 * 
 * @ORM\Entity(repositoryClass="ReferenceRepository")
 * @ORM\Table(name="`references`", indexes={@ORM\Index(name="references_citation_idx", columns={"citation"}), @ORM\Index(name="references_citation_html_idx", columns={"citation_html"})})
 *
 * @author Niels.Klazenga <Niels.Klazenga at rbg.vic.gov.au>
 */
class Reference extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="ReferenceType")
     * @ORM\JoinColumn(name="reference_type_id", referencedColumnName="id")
     * @var \App\Entities\ReferenceType
     */
    protected $referenceType;
    
    /**
     * @ORM\OneToMany(targetEntity="Contributor", mappedBy="reference")
     * @var \Doctrine\Common\Collections\ArrayCollection 
     */
    protected $contributors;
    
    /**
     * @ORM\Column(nullable=true)
     * @var string
     */
    protected $contributorsCache;
    
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     */
    protected $created;
    
    /**
     * @ORM\Column(length=16, nullable=true)
     * @var string
     */
    protected $publicationYear;
    
    /**
     * @ORM\Column(length=300)
     * @var string
     */
    protected $title;
    
    /**
     * @ORM\Column(nullable=true)
     * @var string
     */
    protected $shortTitle;
    
    /**
     * @ORM\ManyToOne(targetEntity="Reference")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @var \App\Entities\Reference
     */
    protected $parent;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $edition;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $volume;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $issue;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $pageStart;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var integer
     */
    protected $pageEnd;
    
    /**
     * @ORM\Column(nullable=true)
     * @var string
     */
    protected $pages;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $numberOfPages;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $publisher;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $placeOfPublication;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $shortDescription;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $abstract;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $isbn;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $issn;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $doi;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $citation;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $citationHtml;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string 
     */
    protected $url;
            
    public function __construct() 
    {
        $this->contributors = new ArrayCollection();
    }
    
    /**
     * 
     * @return \App\Entities\ReferenceType
     */
    public function getReferenceType()
    {
        return $this->referenceType;
    }
    
    /**
     * 
     * @param \App\Entities\ReferenceType $referenceType
     */
    public function setReferenceType(ReferenceType $referenceType)
    {
        $this->referenceType = $referenceType;
    }
    
    /**
     * 
     * @return string
     */
    public function getCitation()
    {
        return $this->citation;
    }
    
    /**
     * 
     * @param string $citation
     */
    public function setCitation($citation)
    {
        $this->citation = $citation;
    }
    
    /**
     * 
     * @return string
     */
    public function getCitationHtml() 
    {
        return $this->citationHtml;
    }
    
    /**
     * 
     * @param string $citationHtml
     */
    public function setCitationHtml($citationHtml)
    {
        $this->citationHtml = $citationHtml;
    }
    
    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getContributors()
    {
        return $this->contributors;
    }
    
    /**
     * 
     * @param \App\Entities\Contributor $contributor
     */
    public function addContributor(Contributor $contributor)
    {
        $this->contributors[] = $contributor;
    }
    
    /**
     * 
     * @return string
     */
    public function getContributorsCache()
    {
        return $this->contributorsCache;
    }
    
    /**
     * 
     * @param string $str
     */
    public function setContributorsCache($str)
    {
        $this->contributorsCache = $str;
    }
    
    /**
     * 
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * 
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }
    
    /**
     * 
     * @return type
     */
    public function getPublicationYear()
    {
        return $this->publicationYear;
    }
    
    /**
     * 
     * @param string $year
     */
    public function setPublicationYear($year)
    {
        $this->publicationYear = $year;
    }
    
    /**
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * 
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * 
     * @return string
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }
    
    /**
     * 
     * @param string $shortTitle
     */
    public function setShortTitle($shortTitle)
    {
        $this->shortTitle = $shortTitle;
    }
    
    /**
     * 
     * @return \App\Entities\Reference
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * 
     * @param \App\Entities\Reference $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
    
    /**
     * 
     * @return string
     */
    public function getEdition()
    {
        return $this->edition;
    }
    
    /**
     * 
     * @param string $edition
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;
    }
    
    /**
     * 
     * @return string
     */
    public function getVolume()
    {
        return $this->volume;
    }
    
    /**
     * 
     * @param string $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }
    
    /**
     * 
     * @return string
     */
    public function getIssue()
    {
        return $this->issue;
    }
    
    /**
     * 
     * @param string $issue
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;
    }
    
    /**
     * 
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * 
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }
    
    /**
     * 
     * @return int
     */
    public function getPageStart()
    {
        return $this->pageStart;
    }
    
    /**
     * 
     * @param int $page
     */
    public function setPageStart($page)
    {
        $this->pageStart = $page;
    }
    
    /**
     * 
     * @return int
     */
    public function getPageEnd()
    {
        return $this->pageEnd;
    }
    
    /**
     * 
     * @param int $page
     */
    public function setPageEnd($page)
    {
        $this->pageEnd = $page;
    }
    
    /**
     * 
     * @return string
     */
    public function getPages()
    {
        return $this->pages;
    }
    
    /**
     * 
     * @param string $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }
    
    /**
     * 
     * @return int
     */
    public function getNumberOfPages()
    {
        return $this->numberOfPages;
    }
    
    /**
     * 
     * @param int $number
     */
    public function setNumberOfPages($number)
    {
        $this->numberOfPages = $number;
    }
    
    /**
     * 
     * @return int
     */
    public function getPublisher()
    {
        return $this->publisher;
    }
    
    /**
     * 
     * @param string $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }
    
    /**
     * 
     * @return string
     */
    public function getPlaceOfPublication()
    {
        return $this->placeOfPublication;
    }
    
    /**
     * 
     * @param string $place
     */
    public function setPlaceOfPublication($place)
    {
        $this->placeOfPublication = $place;
    }
    
    /**
     * 
     * @return string
     */
    public function getShortDescription() 
    {
        return $this->shortDescription;
    }
    
    /**
     * 
     * @param string $description
     */
    public function setShortDescription($description)
    {
        $this->shortDescription = $description;
    }
    
    /**
     * 
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }
    
    /**
     * 
     * @param string $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }
    
    /**
     * 
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }
    
    /**
     * 
     * @param string $isbn
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }
    
    /**
     * 
     * @return string
     */
    public function getIssn()
    {
        return $this->issn;
    }
    
    /**
     * 
     * @param string $issn
     */
    public function setIssn($issn)
    {
        $this->issn = $issn;
    }
    
    /**
     * 
     * @return string
     */
    public function getDoi()
    {
        return $this->doi;
    }
    
    /**
     * 
     * @param string $doi
     */
    public function setDoi($doi)
    {
        $this->doi = $doi;
    }
    
    /**
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * 
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
