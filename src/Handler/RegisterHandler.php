<?php

namespace App\Handler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * Interface RegisterHandler
 * @package App\Handler
 */
interface RegisterHandler
{
    /**
     * @param Request $request
     * @return Response
     */
    public function post(Request $request) : Response;
}