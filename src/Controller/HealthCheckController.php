<?php
/**
 * Created by PhpStorm.
 * User: anru
 * Date: 02-Feb-19
 * Time: 10:33 AM
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HealthCheckController extends AbstractController
{
    public function index()
    {
        return new JsonResponse(['pong']);
    }
}