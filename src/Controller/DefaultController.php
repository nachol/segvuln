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
        

    	$date = new \DateTime('first day of this month');

        return ($this->render(
            'index.html.twig', [
                'criticas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0)),
                'altas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(1)),
                'medias' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(2)),
                'criticasMes' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0, $date)),
                'altasMes' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(1, $date)),
                'mediasMes' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(2, $date)),
                'activas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 1])),
                'inactivas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 0])),
                'aceptadas' => count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 2])),
                'KPI' => $this->calcularKPI()
                ]
            ));
    }

    public function calcularKPI()
    {

        $totalDias = 0;


        $mesesAtras = new \DateTime();

        $mesesAtras->modify('-3 months');

        $criticas = $this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findByFecha2(0, $mesesAtras);

        $altas = $this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findByFecha2(1, $mesesAtras);

        $totalVulnerabilidades = count($criticas) + count($altas);

        $hoy= new \DateTime();

        foreach ($criticas as $vuln) {
            if($vuln->getEstado() == 1){
                $totalDias += $hoy->diff($mesesAtras)->format("%a");
            }else{
                $totalDias += $hoy->diff($vuln->getFechaModificacion())->format("%a");
            } 
        }

        foreach ($altas as $vuln) {
            if($vuln->getEstado() == 1){
                $totalDias += $hoy->diff($mesesAtras)->format("%a");
            }else{
                $totalDias += $hoy->diff($vuln->getFechaModificacion())->format("%a");
            } 
        }

        return ['dias' => $totalDias, 'totalVulnerabilidades' => $totalVulnerabilidades];
    }
}
