<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Parsedown;

class AdminController extends ApiController
{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function updateCaches(Request $request)
    {
        if ($request->user()->getId() != 1) {
            return response()->json([
                'status' => 403,
                'message' => 'You are not authorised for this request'
            ], 403);
        }
        $repo = $this->em->getRepository('\App\Entities\Reference');
        $references = $repo->findAll();
        foreach ($references as $ref) {
            $contributors = $repo->getContributorString($ref);
            $ref->setContributorsCache($contributors);
            $refString = $repo->getReferenceString($ref);
            $html = $this->parseMarkdown($refString);
            $ref->setCitationHtml($html);
            $ref->setCitation($this->htmlToText($html));
        }
        $this->em->flush();
        return response()->json(['message' => 'All contributor caches have been updated by ' . \Auth::User()->getName()]);
    }

    protected function parseMarkdown($str)
    {
        $parser = new Parsedown();
        $html = $parser->line($str);
        $html = str_replace('&zwj;', '', $html);
        $html = str_replace('<em></em>', '', $html);
        return $html;
    }
    
    protected function htmlToText($str)
    {
        $text = strip_tags($str);
        return html_entity_decode($text);
    }
}
