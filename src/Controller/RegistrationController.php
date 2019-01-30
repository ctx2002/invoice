<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Core\Security;
use App\Handler\Registration;
use App\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Log\LoggerInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{

    /**
     * @var Security
     */
    protected $security;

    /**
     * RegistrationController constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }


    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        if ($this->security->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user,
            ['action' => $this->generateUrl('app_register_post')]);

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Registration $service
     * @param LoggerInterface $logger
     * @return Response
     * @throws \Exception
     */
    public function post(Request $request, Registration $service, LoggerInterface $logger): Response
    {
        try {
            return $service->post($request);
        } catch (InvalidFormException $e) {
            $logger->error($e->getTraceAsString());
            return new RedirectResponse($this->redirectToRoute('app_register'));
        } catch (\Exception $e) {
            $logger->error($e->getTraceAsString());
            throw $e;
        }
    }
}
