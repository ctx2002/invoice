<?php
/**
 * Created by PhpStorm.
 * User: anru
 * Date: 28-Jan-19
 * Time: 1:33 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends  AbstractController
{
    public function home() : Response
    {
        return $this->render('home.html.twig');
    }
}