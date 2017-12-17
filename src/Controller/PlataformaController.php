<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Plataforma;
use App\Form\PlataformaType;



/**
 * @Route("/plataforma")
 */
class PlataformaController extends Controller
{
    /**
     * @Route("/", name="plataforma")
     */
    public function index()
    {
       	return ($this->render(
            'plataforma/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(Plataforma::class)->findAll()
                ]
            ));
    }

    /**
     * @Route("/new", name="new_plataforma")
     * @Method("GET")
     */
    public function new($value='')
    {
    	$plataforma = new Plataforma();

    	$formulario = $this->createForm(
            PlataformaType::class, $plataforma, [
            'action' => $this->generateUrl('create_plataforma'),
            'method' => "POST",
            ]
        );

        return $this->render(
                'plataforma/new.html.twig', [
                'entidad' => $plataforma,
                'formulario' => $formulario->createView(),
                ]
        ); 
    }

    /**
     * @Route("/new", name="create_plataforma")
     * @Method("POST")
     */
    public function create(Request $request)
    {
    	$plataforma = new Plataforma();

    	$form = $this->createForm(PlataformaType::class, $plataforma);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try{
                $em->persist($plataforma);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Plataforma grabada exitosamente!'
                );
            }  catch (\Exception $e){
                $this->addFlash(
                    'error',
                    'No se ha podido Crear la Plataforma!'
                );
            }
            
            
            return $this->redirectToRoute('plataforma');
 
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando crear la Plataforma!'
            );
        return $this->render(
                'plataforma/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );
    }


    /**
     * @Route("/edit/{id}", name="edit_plataforma")
     * @Method("GET")
     */
    public function edit($id)
    {
        $plataforma = $this->getDoctrine()->getManager()->getRepository(Plataforma::class)->find($id);

        if (!$plataforma) {
            throw $this->createNotFoundException('No se ha encontrado la Plataforma seleccionada.');
        }

        $form = $this->createForm(PlataformaType::class, $plataforma, [
            'action' => $this->generateUrl('update_plataforma', ['id' => $id]),
            'method' => "PUT"
        ]);

        return $this->render(
                'plataforma/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );    
        
    }


    /**
     * @Route("/{id}", name="update_plataforma")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
    	$plataforma = $this->getDoctrine()->getManager()->getRepository(Plataforma::class)->find($id);

    	if (!$plataforma) {
            throw $this->createNotFoundException('No se ha encontrado la Plataforma seleccionado.');
        }

        $form = $this->createForm(PlataformaType::class, $plataforma, ['method' => "PUT"]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	try{
        		$em->persist($plataforma);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Plataforma editada exitosamente!'
                );
                return $this->redirectToRoute('plataforma');
        	}catch (\Exception $ex) {
                $this->addFlash(
                    'error',
                    'Error al tratar de editar el Plataforma!'
                );
                return $this->redirectToRoute('plataforma');
            }
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando guardar la Plataforma!'
            );
        return $this->render(
                'plataforma/edit.html.twig', [
                'formulario' => $form->createView()
                ]
        );

    }

    /**
     * @Route("/delete/{id}", name="delete_plafaforma")
     * @Method("GET")
     */
    public function delete($id)
    {
        $plataforma = $this->getDoctrine()->getManager()->getRepository(Plataforma::class)->find($id);
        
        if (!$plataforma) {
            throw $this->createNotFoundException('No se ha encontrado la Plataforma seleccionada.');
        }
        
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($plataforma);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Plataforma borrada exitosamente!'
                );
            return $this->redirectToRoute('plataforma'); 
        } catch (\Exception $ex) {
            $this->addFlash(
                    'error',
                    'Error al intentar Borrar la plataforma!'
                );
            return $this->redirectToRoute('plataforma'); 
        }
        
    }
}
