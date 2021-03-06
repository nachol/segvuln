<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EscaneoUploadType;
use App\Entity\TipoVuln;
use App\Entity\Escaneo;
use App\Entity\TipoEscaneo;
use App\Entity\Vulnerabilidad;





class AuxController extends Controller
{
    // /**
    //  * @Route("/aux", name="aux")
    //  */
    // public function index()
    // {
    //     return $this->render('aux/index.html.twig', [
    //         'controller_name' => 'AuxController',
    //     ]);
    // }


    /**
     * Upload de Escaneo
     * 
     * @Route("/importar_informe", name="import")
     * @Method("POST")
     */
    public function import(Request $request)
    {
    	$formulario = $this->createForm(
    		EscaneoUploadType::class, [
    			'method' => "POST",
    		]
    	);

    	$formulario->handleRequest($request);
    	if ($formulario->isSubmitted() && $formulario->isValid()) {
    		$file = $formulario['attachment']->getData();

    		$xml=simplexml_load_string(file_get_contents($file->getrealPath())) or die("Error: Cannot create XML Parser");

    		$escaneo = new Escaneo();

    		if($formulario['herramienta']->getData() == 0)
    		{
    			$this->nessus_importer($xml, $formulario['plataforma']->getData());
    		}else{
    			print('Not implemented');
    			die();
    		}

            $this->addFlash(
                    'notice',
                    'Importación realizada con éxito!'
                );

	        return $this->redirectToRoute('escaneo');

    	}
        $this->addFlash(
                    'error',
                    'Error al importar el escaneo!'
                );
        return $this->redirectToRoute('escaneo');

    }


    public function nessus_importer($xml, $plataforma)
    {

    	//Creo el escaneo
    	$escaneo = new Escaneo();
    	$tipo_escaneo = $this->getDoctrine()->getManager()->getRepository(TipoEscaneo::class)->findByDescripcion('Infraestructura');
    	$escaneo->setTipo($tipo_escaneo[0]);
    	$escaneo->setPlataforma($plataforma);
    	$em = $this->getDoctrine()->getManager();

    	foreach ($xml->Report->ReportHost as $host) {
            $hoy = new \DateTime("now");
            $fecha_creacion = new \DateTime((string)end($host->HostProperties->tag));
    		$ip = $host->attributes()->name;
            $escaneo->setFecha($fecha_creacion);
            $escaneo->setDescripcion("[".(string)$xml->Report->attributes()->name."] Importacion Nessus ".$hoy->format('Y-m-d'));

    		foreach ($host->ReportItem as $vuln) {

                $severidad = $vuln->attributes()->severity; 
                if( $severidad < 2){
                    continue;
                }

                $port = (int)$vuln->attributes()->port;
    			$name = (string) $vuln->attributes()->pluginName;
    			$description = (string) $vuln->description;
    			$solution = (string) $vuln->solution;
    			$synopsys = (string) $vuln->synopsis;
    			$output =  (string) $vuln->plugin_output;
    			$nessus_id = (string) $vuln->attributes()->pluginID;

    			$tipo_vuln = $this->getDoctrine()->getManager()->getRepository(TipoVuln::class)->findByNessusID($nessus_id);
    			
    			$vulnerabilidad = new Vulnerabilidad();

    			if ($tipo_vuln) {
    				$vulnerabilidad->setTipo($tipo_vuln[0]);
    			}else{
    				$tipo_vuln = new TipoVuln();
    				$tipo_vuln->setIdNessus($nessus_id);
    				$tipo_vuln->setDescripcion($name);
    				// $tipo_vuln->setDetalle($description . "\n____________________________\n" .$output);
                    $tipo_vuln->setDetalle($description);

    				$tipo_vuln->setMitigacion($solution);
    				

    				if( $severidad == 2){
    					$tipo_vuln->setCriticidad(2);
    				}elseif($severidad == 3){
    					$tipo_vuln->setCriticidad(1);
    				}elseif($severidad > 3){
    					$tipo_vuln->setCriticidad(0);
    				}

    				$vulnerabilidad->setTipo($tipo_vuln);

    				$em->persist($tipo_vuln);
    			}
                $vulnerabilidad->setPort($port);
    			$vulnerabilidad->setEstado(1);
    			$vulnerabilidad->setFechaCreacion($fecha_creacion);
    			$vulnerabilidad->setIp((string)$ip);

                if($escaneo->vulnerabilidadExists($vulnerabilidad)){
                    continue;
                    dump($vulnerabilidad);
                }
                
                $em->persist($vulnerabilidad);
    			$escaneo->addVulnerabilidad($vulnerabilidad);
    		}
    	}
    	$em->persist($escaneo);
		$em->flush();
    	

        // try{
    	// 	$em->persist($escaneo);
    	// 	$em->flush();
    	// 	$this->addFlash(
    	// 		'notice',
    	// 		'Escaneo grabado exitosamente!'
    	// 	);
    	// }  catch (\Exception $e){
    	// 	$this->addFlash(
    	// 		'error',
    	// 		'No se ha podido Crear el Escaneo!'
    	// 	);
    	// }
    }
}
