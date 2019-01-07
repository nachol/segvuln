<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notification;
use App\Form\NotificationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



/**
 * @Route("/notificaciones")
 */
class NotificationController extends Controller
{
    /**
     * @Route("/estado/{estado}", name="notification")
     */
    public function index($estado = 0)
    {
	return ($this->render(
	    'notification/index.html.twig', [
	        //'entidades' => $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll()
		'entidades' => $this->getDoctrine()->getManager()->getRepository(Notification::class)->findBy(["investigacion" => $estado])
	        ]
	    ));
        
    }

    /**
     * @Route("/new", name="new_notification")
     * @Method("GET")
     */
    public function new()
    {
		$notifications = new Notification();
        
        $formulario = $this->createForm(
            NotificationType::class, $notifications, [
            'action' => $this->generateUrl('create_notification'),
            'method' => "POST",
            ]
        );

        return $this->render(
                'notification/new.html.twig', [
                'entidad' => $notifications,
                'formulario' => $formulario->createView(),
                ]
        );  
    }

    /**
     * @Route("/create", name="create_notification")
     * @Method("POST")
     */
    public function create(Request $request)
    {
    	$notifications = new Notification();

        $form = $this->createForm(NotificationType::class, $notifications);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            try{
                $em->persist($notifications);
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
            
            
            return $this->redirectToRoute('notification', ["estado" => $notifications->getInvestigacion()]);
 
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando crear el registro!'
            );
        return $this->render(
                'notification/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );
    }

    /**
     * @Route("/edit/{id}", name="edit_notification")
     * @Method("GET")
     */
    public function edit($id)
    {
        $notification = $this->getDoctrine()->getManager()->getRepository(Notification::class)->find($id);

        if (!$notification) {
            throw $this->createNotFoundException('No se ha encontrado el registro.');
        }

        $form = $this->createForm(NotificationType::class, $notification, [
            'action' => $this->generateUrl('update_notification', ['id' => $id]),
            'method' => "PUT"
        ]);

        return $this->render(
                'notification/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );    
        
    }

    /**
     * @Route("/{id}", name="update_notification")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
    	$notification = $this->getDoctrine()->getManager()->getRepository(Notification::class)->find($id);

    	if (!$notification) {
            throw $this->createNotFoundException('No se ha encontrado el registro.');
        }

        $form = $this->createForm(NotificationType::class, $notification, ['method' => "PUT"]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	try{
		$em->persist($notification);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Registro editado exitosamente!'
                );
                return $this->redirectToRoute('notification', ["estado" => $notification->getInvestigacion()]);
        	}catch (\Exception $ex) {
                $this->addFlash(
                    'error',
                    'Error al tratar de editar el registro!'
                );

                return $this->redirectToRoute('notification');
            }
        }

        $this->addFlash(
                'error',
                'Hubo un error intentando guardar el registro!'
            );
        return $this->render(
                'notification/new.html.twig', [
                'formulario' => $form->createView()
                ]
        );

    }

    /**
     * @Route("/delete/{id}", name="delete_notification")
     * @Method("GET")
     */
    public function delete($id)
    {
        $notification = $this->getDoctrine()->getManager()->getRepository(Notification::class)->find($id);
        
        if (!$notification) {
            throw $this->createNotFoundException('No se ha encontrado el registro.');
        }
        
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($notification);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Registro borrado exitosamente!'
                );
            return $this->redirectToRoute('notification', ["estado" => $notification->getInvestigacion()]); 
        } catch (\Exception $ex) {
            $this->addFlash(
                    'error',
                    'Error al intentar borrar el registro!'
                );
            return $this->redirectToRoute('notification', ["estado" => $notification->getInvestigacion()]); 
        }
        
    }

    /**
     * @Route("/view/{id}", name="view_notification")
     * @Method("GET")
     */
    public function view($id)
    {
        $notification = $this->getDoctrine()->getManager()->getRepository(Notification::class)->find($id);

        if (!$notification) {
            throw $this->createNotFoundException('No se ha encontrado el registro seleccionado.');
        }

        return $this->render(
                'notification/view.html.twig', [
                'entidad' => $notification
                ]
        );
        
    }
}
