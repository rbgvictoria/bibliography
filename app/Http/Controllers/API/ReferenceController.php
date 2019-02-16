<?php

namespace App\Http\Controllers\API;

use App\Entities\Reference;
use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use OpenApi\Annotations as OA;

/**
 * 
 */
class ReferenceController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/references/{reference}",
     *     summary="Gets a Reference",
     *     @OA\Parameter(
     *         in="path",
     *         name="reference",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         ),
     *         description="ID of the Reference"
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="include",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string"
     *             ),
     *             collectionFormat="csv"
     *         ),
     *         description="Extra linked resources to include in the result; linked resources within included resources can be appended, separated by a full stop, e.g. 'parent.author'; multiple resources can be included, separated by a comma. Currently all linked resources are embedded by default."
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="exclude",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string"
     *             ),
     *             collectionFormat="csv"
     *         ),
     *         description="Embedded resources to exclude from the result; format as for the 'include' parameter."
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response.",
     *         @OA\MediaType(
     *           @OA\Schema(
     *             ref="#/components/schemas/Reference"
     *           ),
     *           mediaType="application/json"
     *         )
     *     )
     * )
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) 
    {
        $ref = $this->em->find('\App\Entities\Reference', (int) $id);
        $transformer = new \App\Transformers\ReferenceTransformer();
        $resource = new Fractal\Resource\Item($ref, $transformer, 'references');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) 
    {
        $repo = $this->em->getRepository('\App\Entities\Reference');
        $ref = $repo->findOneBy(['id' => $request->input('id')]);
        $refType = $this->em->getRepository('\App\Entities\ReferenceType')
                ->findOneBy(['name' => $request->input('type')]);
        $ref->setReferenceType($refType);
        $ref->setPublicationYear($request->input('publicationYear'));
        $ref->setTitle($request->input('title'));
        $parent = $request->input('parent');
        if ($parent) {
            $parentRef = $repo->findOneBy(['id' => $parent['id']]);
            $ref->setParent($parentRef);
        }
        $ref->setVolume($request->input('volume'));
        $ref->setIssue($request->input('issue'));
        $ref->setNumber($request->input('number'));
        $ref->setPageStart($request->input('pageStart'));
        $ref->setPageEnd($request->input('pageEnd'));
        $ref->setPages($request->input('pages'));
        $ref->setNumberOfPages($request->input('numberOfPages'));
        $ref->setPublisher($request->input('publisher'));
        $ref->setIsbn ($request->input('isbn'));
        $ref->setIssn ($request->input('issn'));
        $ref->setDoi ($request->input('doi'));
        $author = $request->input('author');
        if ($author) {
            $agent = $this->em->getRepository('\App\Entities\Agent')->findOneBy(['id' => $author['id']]);
            $ref->setAuthor($agent);
        }
        $ref->setCitation($request->input('citation'));
        $ref->setCitationHtml($request->input('citationHtml'));

        $this->em->flush();
        
        $resource = new Fractal\Resource\Item($ref, new \App\Transformers\ReferenceTransformer, 'references');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    /**
     * @OA\Get(
     *     path="/citations",
     *     summary="Gets Citations (which are summaries of References)",
     *     @OA\Parameter(
     *         in="query",
     *         name="filter[author]",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         ),
     *         description="Author of a Reference"
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="filter[year]",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         ),
     *         description="Publication year of a Reference"
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="filter[type]",
     *         required=false,
     *         @OA\Schema(
     *           type="string",
     *           enum={"Journal","Series","Book","Article","Chapter","Website","Webpage","AudioVisualDocument","MultiVolumeBook","Periodical","Report"}
     *         ),
     *         description="Type of Reference"
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="perPage",
     *         required=false,
     *         @OA\Schema(
     *           type="integer",
     *           default="20"
     *         ),
     *         description="Number of results to return"
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="page",
     *         required=false,
     *         @OA\Schema(
     *           type="integer",
     *           default="1"
     *         ),
     *         description="Number of results to return"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response.",
     *         @OA\MediaType(
     *           @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *               ref="#/components/schemas/Citation"
     *             )
     *           ),
     *           mediaType="application/json"
     *         )
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCitations(Request $request)
    {
        $queryParams = array_diff_key($request->all(), array_flip(['page']));
        $perPage = (isset($queryParams['perPage']))
                ? $queryParams['perPage'] : 20;
        $page = $request->input('page') ?: 1;
        $paginator = $this->em->getRepository('\App\Entities\Reference')
                ->getCitations($queryParams, $perPage, $page);
        if ($perPage) {
            $paginator->appends($queryParams);
            $paginatorAdapter = new IlluminatePaginatorAdapter($paginator);
            $citations = $paginator->getCollection();
            $resource = new Fractal\Resource\Collection($citations, 
                    new \App\Transformers\CitationTransformer, 'citations');
            $resource->setPaginator($paginatorAdapter);
        }
        else {
            $resource = new Fractal\Resource\Collection($paginator, 
                    new \App\Transformers\CitationTransformer, 'citations');
        }
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    /**
     * @OA\Get(
     *     path="/autocomplete/reference",
     *     summary="Reference autocomplete",
     *     description="Gives the same result as the /citations service, but without the pagination and the search term is a simple string",
     *     tags={"Autocomplete"},
     *     @OA\Parameter(
     *         in="query",
     *         name="term",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         ),
     *         description="Search term; the search string can contain the surname of the first author, or the first letters thereof, and, optionally, the year of publication"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response.",
     *         @OA\MediaType(
     *           @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *               ref="#/components/schemas/Citation"
     *             )
     *           ),
     *           mediaType="application/json"
     *         )
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $term = $request->input('term');
        $params = [
            'filter' => [
                'author' => $term,
                'year' => null
            ]
        ];
        $pieces = explode(' ', $term);
        $n = count($pieces);
        if ($n > 1 && is_numeric($pieces[$n-1])) {
            $params['filter']['year'] = array_pop($pieces);
            $params['filter']['author'] = implode('% %', $pieces);
        }
        elseif ($n > 1) {
            $params['filter']['author'] = implode('% %', $pieces);
        }
        $references = $this->em->getRepository('\App\Entities\Reference')
                ->getCitations($params, false);
        $resource = new Fractal\Resource\Collection($references, 
                new \App\Transformers\CitationTransformer, 'citations');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data['data']);
    }
    
    /**
     * @OA\Get(
     *     path="/autocomplete/journal",
     *     summary="Journal autocomplete",
     *     tags={"Autocomplete"},
     *     @OA\Parameter(
     *         in="query",
     *         name="term",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         ),
     *         description="Search term: first letters of the name of the journal"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response.",
     *         @OA\MediaType(
     *           @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *               ref="#/components/schemas/Suggestion"
     *             )
     *           ),
     *           mediaType="application/json"
     *         )
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return vo\Illuminate\Http\Responseid
     */
    public function autocompleteJournal(Request $request)
    {
        $title = $request->input('term');
        $type = [
            'Journal',
            'Periodical'
        ];
        $references = $this->em->getRepository('\App\Entities\Reference')
                ->searchTitle($title, $type);
        $resource = new Fractal\Resource\Collection($references, 
                new \App\Transformers\TitleSuggestionTransformer, 'suggestions');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data['data']);
    }
    
    /**
     * @OA\Get(
     *     path="/autocomplete/book",
     *     summary="Book autocomplete",
     *     tags={"Autocomplete"},
     *     @OA\Parameter(
     *         in="query",
     *         name="term",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         ),
     *         description="Search term: first letters of the surname of the first author of the book"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response.",
     *         @OA\MediaType(
     *           @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *               ref="#/components/schemas/Suggestion"
     *             )
     *           ),
     *           mediaType="application/json"
     *         )
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function autocompleteBook(Request $request) 
    {
        $term = $request->input('term');
        $params = [
            'filter' => [
                'author' => $term,
                'year' => null
            ]
        ];
        $pieces = explode(' ', $term);
        $n = count($pieces);
        if ($n > 1 && is_numeric($pieces[$n-1])) {
            $params['filter']['year'] = array_pop($pieces);
            $params['filter']['author'] = implode('% %', $pieces);
        }
        elseif ($n > 1) {
            $params['filter']['author'] = implode('% %', $pieces);
        }
        $params['filter']['type'] = 'Book';
        $references = $this->em->getRepository('\App\Entities\Reference')
                ->getCitations($params, 0);
        $resource = new Fractal\Resource\Collection($references, 
                new \App\Transformers\ReferenceSuggestionTransformer, 'citations');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data['data']);
    }
}


