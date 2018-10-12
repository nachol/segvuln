<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Vulnerabilidad;
use App\Entity\VampsAPI;



class DefaultController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function test($value='')
    {
        $vamps = new VampsAPI();
        $vamps->getVulns();
        
    }


    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        
        return ($this->render(
            'index.html.twig', [
                'criticas' => $this->getCriticas(),
                'altas' => $this->getAltas(),
                'medias' => $this->getMedias(),
                'criticasMes' => $this->getCriticasMes(),
                'altasMes' => $this->getAltasMes(),
                'mediasMes' => $this->getMediasMes(),
                'activas' => $this->getActivas(),
                'inactivas' => $this->getRemediadas(),
                'aceptadas' => $this->getAceptadas(),
                'KPI' => $this->calcularKPI()
                ]
            ));
    }

    /**
     * @Route("/API/kpi", name="api_kpi")
     */
    public function calcularKPI(Request $request=null)
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

        // Por error de division por 0 si no hay vulnerabilidades
        if($totalVulnerabilidades>0) {
            $promDias = $totalDias/$totalVulnerabilidades;
        }else{
            $promDias = 0;
        }

        $result = [
            'dias' => $totalDias,
            'totalVulnerabilidades' => $totalVulnerabilidades,
            'resultado' => $promDias
        ];

        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result;
    }

     /**
     * @Route("/API/criticas", name="api_criticas")
     */
    public function getCriticas(Request $request=null)
    {
        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(0));
        
        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result;
    }

    /**
     * @Route("/API/altas", name="api_altas")
     */
    public function getAltas(Request $request=null)
    {
        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(1));

        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result;
    }

    /**
     * @Route("/API/medias", name="api_medias")
     */
    public function getMedias(Request $request=null)
    {
        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findActivas(2));

        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result;
    }

    /**
     * @Route("/API/criticas/mes", name="api_criticas_mes")
     */
    public function getCriticasMes(Request $request=null)
    {

        $date = new \DateTime('first day of this month');

        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findByFecha(0, $date));

        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result;
    }

    /**
     * @Route("/API/altas/mes", name="api_altas_mes")
     */
    public function getAltasMes(Request $request=null)
    {

        $date = new \DateTime('first day of this month');

        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findByFecha(1, $date));

        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result; 
    }

    /**
     * @Route("/API/medias/mes", name="api_medias_mes")
     */
    public function getMediasMes(Request $request=null)
    {

        $date = new \DateTime('first day of this month');

        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findByFecha(2, $date));

        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result; 
    }

    /**
     * @Route("/API/activas", name="api_activas")
     */
    public function getActivas(Request $request=null)
    {
        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 1]));


        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result; 

    }

    /**
     * @Route("/API/remediadas", name="api_remediadas")
     */
    public function getRemediadas(Request $request=null)
    {


        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 0]));


        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result; 

    }

    /**
     * @Route("/API/aceptadas", name="api_aceptadas")
     */
    public function getAceptadas(Request $request=null)
    {


        $result = count($this->getDoctrine()->getManager()->getRepository(Vulnerabilidad::class)->findBy(['estado' => 2]));


        if($request){
            $response = new Response();
            $response->setContent(json_encode($result));
            return $response;
        }
        
        return $result; 

    }
}
