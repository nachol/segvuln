<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Vulnerabilidad;


/**
 * @Route("/vulnerabilidad")
 */
class VulnerabilidadController extends Controller
{
    /**
     * @Route("/", name="vulnerabilidad")
     */
    public function index()
    {
        return ($this->render(
            'vulnerabilidad/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findAll()
                ]
            ));
    }
}
