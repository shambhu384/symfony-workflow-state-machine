<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Workflow\Exception\ExceptionInterface;
use Symfony\Component\Workflow\WorkflowInterface;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("", name="order_index")
     */
    public function index()
    {
        return $this->render('Order/index.html.twig', [
            'Orders' => $this->get('doctrine')->getRepository('App:Order')->findAll(),
        ]);
    }

    /**
     * @Route("/create", methods={"POST"}, name="order_create")
     */
    public function create(Request $request)
    {
        $Order = new Order($request->request->get('title', 'title'));

        $em = $this->get('doctrine')->getManager();
        $em->persist($Order);
        $em->flush();

        return $this->redirect($this->generateUrl('order_show', ['id' => $Order->getId()]));
    }

    /**
     * @Route("/show/{id}", name="order_show")
     */
    public function show(Order $Order)
    {
        return $this->render('order/show.html.twig', [
            'order' => $Order,
        ]);
    }

    /**
     * @Route("/apply-transition/{id}", methods={"POST"}, name="order_apply_transition")
     */
    public function applyTransition(WorkflowInterface $orderWorkflow, Request $request, Order $Order)
    {
        try {
            $orderWorkflow
                ->apply($Order, $request->request->get('transition'), [
                    'time' => date('y-m-d H:i:s'),
                ]);
            $this->get('doctrine')->getManager()->flush();
        } catch (ExceptionInterface $e) {
            $this->get('session')->getFlashBag()->add('danger', $e->getMessage());
        }

        return $this->redirect(
            $this->generateUrl('order_show', ['id' => $Order->getId()])
        );
    }

    /**
     * @Route("/reset-marking/{id}", methods={"POST"}, name="order_reset_marking")
     */
    public function resetMarking(Order $order)
    {
        $Order->setMarking([]);
        $this->get('doctrine')->getManager()->flush();

        return $this->redirect($this->generateUrl('order_show', ['id' => $Order->getId()]));
    }
}
