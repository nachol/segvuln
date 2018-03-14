<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Cyberthreats;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CyberthreatsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



/**
 * @Route("/cyberthreats")
 */
class CyberthreatsController extends Controller
{
    /**
     * @Route("/", name="cyberthreats")
     */
    public function index()
    {
        return ($this->render(
            'cyberthreats/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(Cyberthreats::class)->findAll()
                ]
            ));
    }

     /**
     * @Route("/new", name="new_cyberthreat")
     * @Method("GET")
     */
    public function new()
    {
		$cyberthreats = new Cyberthreats();
        
        $formulario = $this->createForm(
            CyberthreatsType::class, $cyberthreats, [
            'action' => $this->generateUrl('create_cyberthreat'),
            'method' => "POST",
            ]
        );

        return $this->render(
                'cyberthreats/new.html.twig', [
                'entidad' => $cyberthreats,
                'formulario' => $formulario->createView(),
                ]
        );  
    }


    /**
     * @Route("/create", name="create_cyberthreat")
     * @Method("POST")
     */
    public function create(Request $request)
    {
    	$cyberthreats = new Cyberthreats();

        $form = $this->createForm(CyberthreatsType::class, $cyberthreats);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try{
                $em->persist($cyberthreats);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Cyberthreat grabado exitosamente!'
                );
            }  catch (\Exception $e){
                $this->addFlash(
                    'error',
                    'No se ha podido Crear el Cyberthreat!'
                );
            }
            
            
            return $this->redirectToRoute('cyberthreats');
 
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando crear El Cyberthreat!'
            );
        return $this->render(
                'tipo_escaneo/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );
    }

    /**
     * @Route("/edit/{id}", name="edit_cyberthreat")
     * @Method("GET")
     */
    public function edit($id)
    {
        $cyberthreat = $this->getDoctrine()->getManager()->getRepository(Cyberthreats::class)->find($id);

        if (!$cyberthreat) {
            throw $this->createNotFoundException('No se ha encontrado la Amenaza.');
        }

        $form = $this->createForm(CyberthreatsType::class, $cyberthreat, [
            'action' => $this->generateUrl('update_cyberthreat', ['id' => $id]),
            'method' => "PUT"
        ]);

        return $this->render(
                'cyberthreats/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );    
        
    }

    /**
     * @Route("/{id}", name="update_cyberthreat")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
    	$cyberthreat = $this->getDoctrine()->getManager()->getRepository(Cyberthreats::class)->find($id);

    	if (!$cyberthreat) {
            throw $this->createNotFoundException('No se ha encontrado la Amenaza.');
        }

        $form = $this->createForm(CyberthreatsType::class, $cyberthreat, ['method' => "PUT"]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	try{
        		$em->persist($cyberthreat);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Amenaza editada exitosamente!'
                );
                return $this->redirectToRoute('cyberthreats');
        	}catch (\Exception $ex) {
                $this->addFlash(
                    'error',
                    'Error al tratar de editar la Amenaza!'
                );
                return $this->redirectToRoute('cyberthreats');
            }
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando guardar la Amenaza!'
            );
        return $this->render(
                'cyberthreats/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );

    }

    /**
     * @Route("/delete/{id}", name="delete_cyberthreat")
     * @Method("GET")
     */
    public function delete($id)
    {
        $cyberthreat = $this->getDoctrine()->getManager()->getRepository(Cyberthreats::class)->find($id);
        
        if (!$cyberthreat) {
            throw $this->createNotFoundException('No se ha encontrado la Amenaza.');
        }
        
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($cyberthreat);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Amenaza borrada exitosamente!'
                );
            return $this->redirectToRoute('cyberthreats'); 
        } catch (\Exception $ex) {
            $this->addFlash(
                    'error',
                    'Error al intentar Borrar la Amenaza!'
                );
            return $this->redirectToRoute('cyberthreats'); 
        }
        
    }
}
