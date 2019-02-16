<?php

namespace App\Http\Controllers\API;

use App\Exceptions\InvalidUuidException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal;
use Ramsey\Uuid\Uuid;
use OpenApi\Annotations as OA;

/**
 * The ApiController class is the superclass of all API controllers; it contains
 * some methods that are used in all these controllers
 *
 * @OA\OpenApi(
 *   @OA\Info(
 *     title="Bibliography API",
 *     description="",
 *     version="1.0.0",
 *     @OA\Contact(
 *       name="Niels Klazenga, Royal Botanic Gardens Victoria",
 *       email="Niels.Klazenga@rbg.vic.gov.au"
 *     )
 *   ),
 *   @OA\Server(
 *     description="",
 *     url="http://reference.homestead/api"
 *   )
 * )
 */
class ApiController extends Controller
{
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var Fractal\Manager
     */
    protected $fractal;
    
    /** */
    public function __construct()
    {
        $this->middleware('cors');
        $this->em = app('em');
        $this->setFractalManager();
    }

    /**
     * Sets the Fractal manager, with the appropriate response type based on the
     * Accept header and parses the requested includes and excludes
     */
    protected function setFractalManager()
    {
        $this->fractal = new Fractal\Manager();
        $this->fractal->setSerializer(new \App\Serializers\DataArraySerializer());
        if (\request()->input('include')) {
            $this->fractal->parseIncludes(\request()->input('include'));
        }
        if (\request()->input('exclude')) {
            $this->fractal->parseExcludes(\request()->input('exclude'));
        }
    }

    /**
     * @param  Uuid $id
     * @return InvalidUuidException
     */
    public function checkUuid($id) {
        if (!Uuid::isValid($id)) {
            throw new InvalidUuidException();
        }
    }

    /**
     * Creates API documentation
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function apiDocs()
    {
        $swagger = \OpenApi\scan(app_path());
        return response()->json($swagger);
    }
    
    /**
     * 
     * @param string $input
     * @param  $entity
     * @param type $vocab
     * @return type
     */
    public function getValue($input, $entity=false, $vocab=false)
    {
        if (is_array($input)) {
            if ($vocab) {
                $input = $input['name'];
            }
            else {
                $input = $input->id;
            }
        }
        if ($entity) {
            if ($vocab) {
                return $this->em->getRepository('\\App\\Entities\\' . $entity)
                        ->findOneBy(['name' => $input]);
            }
            else {
                return $this->em->getRepository('\\App\\Entities\\' . $entity)
                        ->findOneBy(['guid' => $input]);
            }
        }
        else {
            return $input;
        }
    }
}
