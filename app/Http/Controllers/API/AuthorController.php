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

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use League\Fractal;

/**
 * AuthorController
 * 
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class AuthorController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/autocomplete/author",
     *     summary="Author autocomplete",
     *     tags={"Autocomplete"},
     *     @OA\Parameter(
     *         in="query",
     *         name="term",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         ),
     *         description="Search term: first letters of the surname of an individual author"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response.",
     *         @OA\MediaType(
     *           @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *               ref="#/components/schemas/Agent"
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
        $authors = $this->em->getRepository('\App\Entities\Agent')
                ->suggest($request->input('term'));
        $resource = new Fractal\Resource\Collection($authors, 
                new \App\Transformers\AgentTransformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data['data']);
    }
}
