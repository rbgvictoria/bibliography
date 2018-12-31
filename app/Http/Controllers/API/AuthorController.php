<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use League\Fractal;

class AuthorController extends ApiController
{
    public function autocomplete(Request $request)
    {
        $authors = $this->em->getRepository('\App\Entities\Agent')
                ->suggest($request->input('term'));
        $resource = new Fractal\Resource\Collection($authors, 
                new \App\Transformers\AgentTransformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data['data']);
    }
}
