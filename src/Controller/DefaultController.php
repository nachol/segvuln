<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Vulnerabilidad;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {

    	// $criticas = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0));

    	// $altas = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(1));

    	// $medias = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0));

    	$date = new \DateTime('first day of this month');

    	// $criticasMes = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0, $date));

    	// $altasMes = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(1, $date));

    	// $mediasMes = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0, $date));

    	// $activas = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 1]));

    	// $inactivas = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 0]));

    	// $aceptadas = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 2]));

        return ($this->render(
            'index.html.twig', [
                'criticas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0)),
                'altas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(1)),
                'medias' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0)),
                'criticasMes' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0, $date)),
                'altasMes' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(1, $date)),
                'mediasMes' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0, $date)),
                'activas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 1])),
                'inactivas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 0])),
                'aceptadas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 2]))
                ]
            ));
    }
}
