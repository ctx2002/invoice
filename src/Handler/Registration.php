<?php

namespace App\Handler;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\RegistrationFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;
use App\Exception\InvalidFormException;

/**
 * Class Registration
 * @package App\Handler
 */
class Registration implements RegisterHandler
{

    /**
     * @var ObjectManager
     */
    protected $om;
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;
    /**
     * @var GuardAuthenticatorHandler
     */
    protected $guardHandler;
    /**
     * @var LoginFormAuthenticator
     */
    protected $authenticator;

    /**
     * Registration constructor.
     * @param ObjectManager $om
     * @param FormFactoryInterface $formFactory
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     */
    public function __construct(ObjectManager $om,
                                FormFactoryInterface $formFactory,
                                UserPasswordEncoderInterface $passwordEncoder,
                                GuardAuthenticatorHandler $guardHandler,
                                LoginFormAuthenticator $authenticator)
    {
        $this->om = $om;
        $this->formFactory = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
        $this->guardHandler = $guardHandler;
        $this->authenticator = $authenticator;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function post(Request $request): Response
    {
        $user = new User();

        $form = $this->formFactory->create(RegistrationFormType::class, $user, array('method' => 'POST'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->om->persist($user);
            $this->om->flush();

            return $this->guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->authenticator,
                'main' // firewall name in security.yaml
            );
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

}