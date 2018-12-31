<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ReferenceController extends ApiController
{
    
    public function show($id) {
        $ref = $this->em->getRepository('\App\Entities\Reference')
                ->findOneBy(['guid' => $id]);
        $transformer = new \App\Transformers\ReferenceTransformer();
        $resource = new Fractal\Resource\Item($ref, $transformer, 'references');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    public function getCitations(Request $request)
    {
        $queryParams = array_diff_key($request->all(), array_flip(['page']));
        $perPage = (isset($queryParams['perPage']))
                ? $queryParams['perPage'] : 20;
        $page = $request->input('page') ?: 1;
        $paginator = $this->em->getRepository('\App\Entities\Reference')->getCitations($queryParams, $perPage, $page);
        if ($perPage) {
            $paginator->appends($queryParams);
            $paginatorAdapter = new IlluminatePaginatorAdapter($paginator);
            $citations = $paginator->getCollection();
            $resource = new Fractal\Resource\Collection($citations, new \App\Transformers\CitationTransformer, 'citations');
            $resource->setPaginator($paginatorAdapter);
        }
        else {
            $resource = new Fractal\Resource\Collection($paginator, new \App\Transformers\CitationTransformer, 'citations');
        }
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    public function autocomplete(Request $request)
    {
        $term = $request->input('term');
        $params = [
            'author' => $term,
            'year' => null
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
                ->getCitations($params, 0);
        $resource = new Fractal\Resource\Collection($references, 
                new \App\Transformers\CitationTransformer, 'citations');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data['data']);
    }
    
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


