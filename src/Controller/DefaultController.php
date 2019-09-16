<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Model\CustomerModel;
use App\Model\CustomersModel;
use App\Service\MindBoxService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route(path="/",name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route(path="/register",name="register")
     * @param Request $request
     * @param MindBoxService $mindBoxService
     * @return Response
     * @throws \Exception
     */
    public function registerAction(Request $request, MindBoxService $mindBoxService)
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $customers = new CustomersModel();
            $customer = new CustomerModel();
            $customer->setMobilePhone($data['mobilePhone']);
            $customer->setFullName($data['fullName']);
            $customer->setEmail($data['email']);
            $customer->setPlainPassword($data['plainPassword']);
            $customer->setSubscriptions(new ArrayCollection($data['subscriptions']));
            $customer->setIds(new ArrayCollection($data['ids']));
            foreach ($data['customFields'] as $field) {
                $customer->setCustomField($field['name'], $field['value']);
            }
            $customers->setCustomer($customer);
            $mindBoxService->asyncRegister($customers);
        }

        return $this->render(
            'register.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}