<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Escaneo;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EscaneoType;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @Route("/escaneo")
 */
class EscaneoController extends Controller
{

    /**
     * Lista de Escaneos
     * 
     * @Route("/estado/{estado}", name="escaneo"))
     * @Method("GET")
     */
    public function index($estado = null)
    {

        if($estado == null)
        {
            return ($this->render(
            'escaneo/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(Escaneo::class)->findAll()
                ]
            ));
        }

        return ($this->render(
            'escaneo/index.html.twig', [
                'entidades' => $this->getDoctrine()->getManager()->getRepository(Escaneo::class)->findByEstadoVulnerabilidad($estado),
                'estado' => 1
                ]
            ));
    }

    /**
     * Muestra la pantalla para la creacion de un nuevo Escaneo
     * 
     * 
     * @Route("/new", name="adm_escaneo_new")
     * @Method("GET")
     */
    public function new()
    {
        $escaneo = new Escaneo();
        
        $formulario = $this->createForm(
            EscaneoType::class, $escaneo, [
            'action' => $this->generateUrl('adm_escaneo_create'),
            'method' => "POST",
            ]
        );

        return $this->render(
                'escaneo/new.html.twig', [
                'entidad' => $escaneo,
                'formulario' => $formulario->createView(),
                ]
        );  
        
    }

    /**
     * Crea un Escaneo.
     * 
     * Se ejecuta desde el botón crear ubicado en la pantalla new
     * 
     * @Route("/", name="adm_escaneo_create")
     * @Method("POST")
     */
    public function create(Request $request)
    {
        $escaneo = new Escaneo();

        $form = $this->createForm(EscaneoType::class, $escaneo);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            //Check if bulk creation
            foreach ($escaneo->getVulnerabilidades() as $vuln) {


                if ($vuln->getCantidad() > 1){

                    for($i=1; $i < $vuln->getCantidad(); $i++){
                        $vuln2 = clone $vuln;

                        $escaneo->addVulnerabilidad($vuln2);
                    }
                }
            }

            $em = $this->getDoctrine()->getManager();
            try{
                $em->persist($escaneo);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Escaneo grabado exitosamente!'
                );
            }  catch (\Exception $e){
                $this->addFlash(
                    'error',
                    'No se ha podido Crear el Escaneo!'
                );
            }
            
            
            return $this->redirectToRoute('escaneo');
 
        }
        $this->addFlash(
                'error',
                'Hubo un error intentando crear El escaneo!'
            );
        return $this->render(
                'escaneo/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );
    }

    /**
     * @Route("/edit/{id}", name="edit_escaneo")
     * @Method("GET")
     */
    public function edit($id)
    {
        $escaneo = $this->getDoctrine()->getManager()->getRepository(Escaneo::class)->find($id);

        if (!$escaneo) {
            throw $this->createNotFoundException('No se ha encontrado el Escaneo seleccionado.');
        }

        $form = $this->createForm(EscaneoType::class, $escaneo, [
            'action' => $this->generateUrl('update_escaneo', ['id' => $id]),
            'method' => "PUT"
        ]);

        return $this->render(
                'escaneo/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );    
        
    }

    /**
     * @Route("/put/{id}", name="update_escaneo")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
        $escaneo = $this->getDoctrine()->getManager()->getRepository(Escaneo::class)->find($id);

        if (!$escaneo) {
            throw $this->createNotFoundException('No se ha encontrado el Escaneo seleccionado.');
        }

        $vulnerabilidadesOriginales = new ArrayCollection();

        foreach ($escaneo->getVulnerabilidades() as $vulnerabilidad) {
            $vulnerabilidadesOriginales->add($vulnerabilidad);
        }


        $form = $this->createForm(EscaneoType::class, $escaneo, ['method' => "PUT"]);

        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($vulnerabilidadesOriginales as $vulnerabilidad) {
                if (false === $escaneo->getVulnerabilidades()->contains($vulnerabilidad)) {
                    $escaneo->getVulnerabilidades()->removeElement($vulnerabilidad);

                    $em->remove($vulnerabilidad);
                }
            }
            
            try{
                $em->persist($escaneo);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Escaneo editado exitosamente!'
                );
                return $this->redirectToRoute('escaneo');
            }catch (\Exception $ex) {
                $this->addFlash(
                    'error',
                    'Error al tratar de editar el Escaneo!'
                );
                return $this->redirectToRoute('escaneo');
            }
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando guardar el Escaneo!'
            );
        return $this->render(
                'escaneo/edit.html.twig', [
                'formulario' => $form->createView()
                ]
        );

    }

    /**
     * @Route("/delete/{id}", name="delete_escaneo")
     * @Method("GET")
     */
    public function delete($id)
    {
        $escaneo = $this->getDoctrine()->getManager()->getRepository(Escaneo::class)->find($id);
        
        if (!$escaneo) {
            throw $this->createNotFoundException('No se ha encontrado el Escaneo seleccionado.');
        }
        
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($escaneo);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Escaneo borrado exitosamente!'
                );
            return $this->redirectToRoute('escaneo'); 
        } catch (\Exception $ex) {
            $this->addFlash(
                    'error',
                    'Error al intentar Borrar el escaneo!'
                );
            return $this->redirectToRoute('escaneo'); 
        }
        
    }

    /**
     * @Route("/view/{id}", name="view_escaneo")
     * @Method("GET")
     */
    public function view($id)
    {
        $escaneo = $this->getDoctrine()->getManager()->getRepository(Escaneo::class)->find($id);

        if (!$escaneo) {
            throw $this->createNotFoundException('No se ha encontrado el Escaneo seleccionado.');
        }

        return $this->render(
                'escaneo/view.html.twig', [
                'entidad' => $escaneo
                ]
        );
        
    }

}
