<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use League\Fractal;

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
}
