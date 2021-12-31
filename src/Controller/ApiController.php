<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @Route("/lucky/number")
     */
    public function myfunction()
    {
        return $this->json([
            "message" => "Success",
            "status" => Response::HTTP_OK
        ]);
    }
}
