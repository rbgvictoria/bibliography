<?php

namespace App\Http\Controllers\API;

use App\Entities\Agent;
use Illuminate\Http\Request;
use League\Fractal;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AgentController extends ApiController
{
    /**
     * Stores a new Agent record in the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $agent = new Agent();
        $type = $this->em->getRepository('\App\Entities\AgentType')
            ->findOneBy(['name' => $request->input('type')]);
        $agent->setAgentType($type);
        $agent->setFirstName($request->input('firstName'));
        $agent->setInitials($request->input('initials'));
        $agent->setLastName($request->input('lastName'));
        $agent->setName($request->input('name'));
        $this->em->persist($agent);
        $members = $request->input('groupMembers');
        if ($members) { 
            foreach ($members as $index => $member) {
                $groupAgent = new \App\Entities\GroupAgent();
                $groupMember = $this->em->getRepository('\App\Entities\Agent')
                        ->findOneBy(['id' => $member['member']['id']]);
                $groupAgent->setSequence($member['sequence']);
                $groupAgent->setGroup($agent);
                $groupAgent->setMember($groupMember);
                $this->em->persist($groupAgent);
                $agent->addGroupMember($groupAgent);
            }
        }
        $this->em->flush();

        $resource = new Fractal\Resource\Item($agent, new \App\Transformers\AgentTransformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();

        return response()->json($data);
    }

    /**
     * Find an Agent with the name provided in the query string
     * 
     * @OA\Get(
     *     path="/agents/findByName",
     *     summary="Finds an Agent with the supplied name",
     *     @OA\Parameter(
     *         in="query",
     *         name="name",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Name for the Agent; syntax of the name string is '<last name>, <initials>'; multiple agent names are separate by '; ', except for the last one, which is separated by ' & '."
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response.",
     *         @OA\MediaType(
     *           @OA\Schema(
     *             ref="#/components/schemas/Agent"
     *           ),
     *           mediaType="application/json"
     *         )
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function findByName(Request $request)
    {
        $agent = $this->em->getRepository('\App\Entities\Agent')
            ->findOneBy(['name' => $request->input('name')]);
        if (!$agent) {
            return response()->json([]);
        }
        $resource = new Fractal\Resource\Item($agent, new \App\Transformers\AgentTransformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
}
