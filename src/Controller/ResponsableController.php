<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Responsable;
use App\Form\ResponsableType;
use Symfony\Component\HttpFoundation\Request;




/**
 * 
 * @Route("/responsable")
 */
class ResponsableController extends Controller
{
    /**
     * @Route("/", name="responsable")
     */
    public function index()
    {
        return ($this->render(
            'responsable/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(Responsable::class)->findAll()
                ]
            ));
    }

    /**
     * @Route("/new", name="new_responsable")
     * @Method("GET")
     */
    public function new()
    {
		$responsable = new Responsable();
        
        $formulario = $this->createForm(
            ResponsableType::class, $responsable, [
            'action' => $this->generateUrl('create_responsable'),
            'method' => "POST",
            ]
        );

        return $this->render(
                'responsable/new.html.twig', [
                'entidad' => $responsable,
                'formulario' => $formulario->createView(),
                ]
        );  
    }

    /**
     * @Route("/create", name="create_responsable")
     * @Method("POST")
     */
    public function create(Request $request)
    {
    	$responsable = new Responsable();

        $form = $this->createForm(ResponsableType::class, $responsable);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try{
                $em->persist($responsable);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Responsable grabado exitosamente!'
                );
            }  catch (\Exception $e){
                $this->addFlash(
                    'error',
                    'No se ha podido Crear el Responsable!'
                );
            }
            
            
            return $this->redirectToRoute('responsable');
 
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando crear El Responsable!'
            );
        return $this->render(
                'responsable/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );
    }


    /**
     * @Route("/edit/{id}", name="edit_responsable")
     * @Method("GET")
     */
    public function edit($id)
    {
        $responsable = $this->getDoctrine()->getManager()->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('No se ha encontrado el Responsable seleccionado.');
        }

        $form = $this->createForm(ResponsableType::class, $responsable, [
            'action' => $this->generateUrl('update_responsable', ['id' => $id]),
            'method' => "PUT"
        ]);

        return $this->render(
                'responsable/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );    
        
    }


    /**
     * @Route("/{id}", name="update_responsable")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
    	$responsable = $this->getDoctrine()->getManager()->getRepository(Responsable::class)->find($id);

    	if (!$responsable) {
            throw $this->createNotFoundException('No se ha encontrado el Responsable seleccionado.');
        }

        $form = $this->createForm(ResponsableType::class, $responsable, ['method' => "PUT"]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	try{
        		$em->persist($responsable);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Responsable editado exitosamente!'
                );
                return $this->redirectToRoute('responsable');
        	}catch (\Exception $ex) {
                $this->addFlash(
                    'error',
                    'Error al tratar de editar el Responsable!'
                );
                return $this->redirectToRoute('responsable');
            }
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando guardar el Responsable!'
            );
        return $this->render(
                'responsable/edit.html.twig', [
                'formulario' => $form->createView()
                ]
        );

    }

    /**
     * @Route("/delete/{id}", name="delete_responsable")
     * @Method("GET")
     */
    public function delete($id)
    {
        $responsable = $this->getDoctrine()->getManager()->getRepository(Responsable::class)->find($id);
        
        if (!$responsable) {
            throw $this->createNotFoundException('No se ha encontrado el Responsable seleccionado.');
        }
        
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($responsable);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Responsable borrado exitosamente!'
                );
            return $this->redirectToRoute('responsable'); 
        } catch (\Exception $ex) {
            $this->addFlash(
                    'error',
                    'Error al intentar Borrar el responsable!'
                );
            return $this->redirectToRoute('responsable'); 
        }
        
    }
}
