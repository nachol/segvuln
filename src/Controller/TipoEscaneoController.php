<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\TipoEscaneo;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TipoEscaneoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



/**
 * @Route("/tipo/escaneo")
 */
class TipoEscaneoController extends Controller
{
    /**
     * @Route("/", name="tipo_escaneo")
     */
    public function index()
    {
        return ($this->render(
            'tipo_escaneo/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(TipoEscaneo::class)->findAll()
                ]
            ));
    }

     /**
     * @Route("/new", name="new_tipo_escaneo")
     * @Method("GET")
     */
    public function new()
    {
		$tipo_escaneo = new TipoEscaneo();
        
        $formulario = $this->createForm(
            TipoEscaneoType::class, $tipo_escaneo, [
            'action' => $this->generateUrl('create_tipo_escaneo'),
            'method' => "POST",
            ]
        );

        return $this->render(
                'tipo_escaneo/new.html.twig', [
                'entidad' => $tipo_escaneo,
                'formulario' => $formulario->createView(),
                ]
        );  
    }


    /**
     * @Route("/create", name="create_tipo_escaneo")
     * @Method("POST")
     */
    public function create(Request $request)
    {
    	$tipo_escaneo = new TipoEscaneo();

        $form = $this->createForm(TipoEscaneoType::class, $tipo_escaneo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try{
                $em->persist($tipo_escaneo);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Tipo de Escaneo grabado exitosamente!'
                );
            }  catch (\Exception $e){
                $this->addFlash(
                    'error',
                    'No se ha podido Crear el Tipo de Escaneo!'
                );
            }
            
            
            return $this->redirectToRoute('tipo_escaneo');
 
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando crear El Tipo de Escaneo!'
            );
        return $this->render(
                'tipo_escaneo/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );
    }

    /**
     * @Route("/edit/{id}", name="edit_tipo_escaneo")
     * @Method("GET")
     */
    public function edit($id)
    {
        $tipo_escaneo = $this->getDoctrine()->getManager()->getRepository(TipoEscaneo::class)->find($id);

        if (!$tipo_escaneo) {
            throw $this->createNotFoundException('No se ha encontrado el Tipo de Escaneo seleccionado.');
        }

        $form = $this->createForm(TipoEscaneoType::class, $tipo_escaneo, [
            'action' => $this->generateUrl('update_tipo_escaneo', ['id' => $id]),
            'method' => "PUT"
        ]);

        return $this->render(
                'tipo_escaneo/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );    
        
    }

    /**
     * @Route("/{id}", name="update_tipo_escaneo")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
    	$tipo_escaneo = $this->getDoctrine()->getManager()->getRepository(TipoEscaneo::class)->find($id);

    	if (!$tipo_escaneo) {
            throw $this->createNotFoundException('No se ha encontrado el Tipo de Escaneo seleccionado.');
        }

        $form = $this->createForm(TipoEscaneoType::class, $tipo_escaneo, ['method' => "PUT"]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	try{
        		$em->persist($tipo_escaneo);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Tipo de Escaneo editado exitosamente!'
                );
                return $this->redirectToRoute('tipo_escaneo');
        	}catch (\Exception $ex) {
                $this->addFlash(
                    'error',
                    'Error al tratar de editar el Tipo de Escaneo!'
                );
                return $this->redirectToRoute('tipo_escaneo');
            }
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando guardar el Tipo de Escaneo!'
            );
        return $this->render(
                'tipo_escaneo/edit.html.twig', [
                'formulario' => $form->createView()
                ]
        );

    }

    /**
     * @Route("/delete/{id}", name="delete_tipo_escaneo")
     * @Method("GET")
     */
    public function delete($id)
    {
        $tipo_escaneo = $this->getDoctrine()->getManager()->getRepository(TipoEscaneo::class)->find($id);
        
        if (!$tipo_escaneo) {
            throw $this->createNotFoundException('No se ha encontrado el Tipo de Escaneo seleccionado.');
        }
        
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($tipo_escaneo);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Tipo de Escaneo borrado exitosamente!'
                );
            return $this->redirectToRoute('tipo_escaneo'); 
        } catch (\Exception $ex) {
            $this->addFlash(
                    'error',
                    'Error al intentar Borrar el Tipo de Escaneo!'
                );
            return $this->redirectToRoute('tipo_escaneo'); 
        }
        
    }
}
