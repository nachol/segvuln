<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Incidente;
use App\Form\IncidenteType;


/**
 * @Route("/incidentes")
 */
class IncidenteController extends Controller
{
    /**
     * @Route("/", name="incidente")
     */
    public function index()
    {
        return ($this->render(
            'incidente/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(Incidente::class)->findAll()
                ]
            ));
    }


    /**
     * @Route("/new", name="new_incidente")
     * @Method("GET")
     */
    public function new()
    {
		$incidente = new Incidente();
        
        $formulario = $this->createForm(
            IncidenteType::class, $incidente, [
            'action' => $this->generateUrl('create_incidente'),
            'method' => "POST",
            ]
        );

        return $this->render(
                'incidente/new.html.twig', [
                'entidad' => $incidente,
                'formulario' => $formulario->createView(),
                ]
        );  
    }

    /**
     * @Route("/create", name="create_incidente")
     * @Method("POST")
     */
    public function create(Request $request)
    {
    	$incidente = new Incidente();

        $form = $this->createForm(IncidenteType::class, $incidente);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        	if($incidente->getEstado() == true){
        		$incidente->setCierre(new \DateTime("NOW"));
        	}

            $em = $this->getDoctrine()->getManager();
            try{
                $em->persist($incidente);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Registro creado exitosamente!'
                );
            }  catch (\Exception $e){
                $this->addFlash(
                    'error',
                    'No se ha podido crear el registro!'
                );
            }
            
            
            return $this->redirectToRoute('incidente');
 
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando crear el registro!'
            );
        return $this->render(
                'incidente/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );
    }

    /**
     * @Route("/edit/{id}", name="edit_incidente")
     * @Method("GET")
     */
    public function edit($id)
    {
        $incidente = $this->getDoctrine()->getManager()->getRepository(Incidente::class)->find($id);

        if (!$incidente) {
            throw $this->createNotFoundException('No se ha encontrado el registro.');
        }

        $form = $this->createForm(IncidenteType::class, $incidente, [
            'action' => $this->generateUrl('update_incidente', ['id' => $id]),
            'method' => "PUT"
        ]);

        return $this->render(
                'incidente/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );    
        
    }

    /**
     * @Route("/{id}", name="update_incidente")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
    	$incidente = $this->getDoctrine()->getManager()->getRepository(Incidente::class)->find($id);

    	if (!$incidente) {
            throw $this->createNotFoundException('No se ha encontrado el registro.');
        }

        $estado_old = $incidente->getEstado();

        $form = $this->createForm(IncidenteType::class, $incidente, ['method' => "PUT"]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

        	if($estado_old == false && $incidente->getEstado() == true){
        		$incidente->setCierre(new \DateTime("NOW"));
        	}

        	if($estado_old == true && $incidente->getEstado() == false){
        		$incidente->setCierre(null);
        	}

        	$em = $this->getDoctrine()->getManager();
        	try{
        		$em->persist($incidente);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Registro editado exitosamente!'
                );
                return $this->redirectToRoute('incidente');
        	}catch (\Exception $ex) {
                $this->addFlash(
                    'error',
                    'Error al tratar de editar el registro!'
                );
                return $this->redirectToRoute('incidente');
            }
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando guardar el registro!'
            );
        return $this->render(
                'cyberthreats/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );

    }

    /**
     * @Route("/delete/{id}", name="delete_incidente")
     * @Method("GET")
     */
    public function delete($id)
    {
        $incidente = $this->getDoctrine()->getManager()->getRepository(Incidente::class)->find($id);
        
        if (!$incidente) {
            throw $this->createNotFoundException('No se ha encontrado el registro.');
        }
        
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($incidente);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Registro borrado exitosamente!'
                );
            return $this->redirectToRoute('incidente'); 
        } catch (\Exception $ex) {
            $this->addFlash(
                    'error',
                    'Error al intentar borrar el registro!'
                );
            return $this->redirectToRoute('incidente'); 
        }
        
    }
}
