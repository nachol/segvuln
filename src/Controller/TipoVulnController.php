<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\TipoVuln;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TipoVulnType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("/tipo/vuln")
 */
class TipoVulnController extends Controller
{
    /**
     * @Route("/", name="tipo_vuln")
     */
    public function index()
    {
        return ($this->render(
            'tipo_vuln/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(TipoVuln::class)->findAll()
                ]
            ));
    }

     /**
     * @Route("/new", name="new_tipo_vuln")
     * @Method("GET")
     */
    public function new()
    {
		$tipo_vuln = new TipoVuln();
        
        $formulario = $this->createForm(
            TipoVulnType::class, $tipo_vuln, [
            'action' => $this->generateUrl('create_tipo_vuln'),
            'method' => "POST",
            ]
        );

        return $this->render(
                'tipo_vuln/new.html.twig', [
                'entidad' => $tipo_vuln,
                'formulario' => $formulario->createView(),
                ]
        );  
    }


    /**
     * @Route("/create", name="create_tipo_vuln")
     * @Method("POST")
     */
    public function create(Request $request)
    {
    	$tipo_vuln = new TipoVuln();

        $form = $this->createForm(TipoVulnType::class, $tipo_vuln);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try{
                $em->persist($tipo_vuln);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Tipo de Vuln grabado exitosamente!'
                );
            }  catch (\Exception $e){
                $this->addFlash(
                    'error',
                    'No se ha podido Crear el Tipo de Vuln!'
                );
            }
            
            
            return $this->redirectToRoute('tipo_vuln');
 
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando crear El Tipo de Vuln!'
            );
        return $this->render(
                'tipo_vuln/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );
    }

    /**
     * @Route("/edit/{id}", name="edit_tipo_vuln")
     * @Method("GET")
     */
    public function edit($id)
    {
        $tipo_vuln = $this->getDoctrine()->getManager()->getRepository(TipoVuln::class)->find($id);

        if (!$tipo_vuln) {
            throw $this->createNotFoundException('No se ha encontrado el Tipo de Vuln seleccionado.');
        }

        $form = $this->createForm(TipoVulnType::class, $tipo_vuln, [
            'action' => $this->generateUrl('update_tipo_vuln', ['id' => $id]),
            'method' => "PUT"
        ]);

        return $this->render(
                'tipo_vuln/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );    
        
    }

    /**
     * @Route("/{id}", name="update_tipo_vuln")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
    	$tipo_vuln = $this->getDoctrine()->getManager()->getRepository(TipoVuln::class)->find($id);

    	if (!$tipo_vuln) {
            throw $this->createNotFoundException('No se ha encontrado el Tipo de Vuln seleccionado.');
        }

        $form = $this->createForm(TipoVulnType::class, $tipo_vuln, ['method' => "PUT"]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	try{
        		$em->persist($tipo_vuln);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Tipo de Vuln editado exitosamente!'
                );
                return $this->redirectToRoute('tipo_vuln');
        	}catch (\Exception $ex) {
                $this->addFlash(
                    'error',
                    'Error al tratar de editar el Tipo de Vuln!'
                );
                return $this->redirectToRoute('tipo_vuln');
            }
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando guardar el Tipo de Vuln!'
            );
        return $this->render(
                'tipo_vuln/edit.html.twig', [
                'formulario' => $form->createView()
                ]
        );

    }

    /**
     * @Route("/delete/{id}", name="delete_tipo_vuln")
     * @Method("GET")
     */
    public function delete($id)
    {
        $tipo_vuln = $this->getDoctrine()->getManager()->getRepository(TipoVuln::class)->find($id);
        
        if (!$tipo_vuln) {
            throw $this->createNotFoundException('No se ha encontrado el Tipo de Vulnerabilidad seleccionado.');
        }
        
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($tipo_vuln);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Tipo de Vulnerabilidad borrado exitosamente!'
                );
            return $this->redirectToRoute('tipo_vuln'); 
        } catch (\Exception $ex) {
            $this->addFlash(
                    'error',
                    'Error al intentar Borrar el Tipo de Vulnerabilidad!'
                );
            return $this->redirectToRoute('tipo_vuln'); 
        }
        
    }
}
