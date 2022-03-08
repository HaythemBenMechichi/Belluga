<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Knp\Component\Pager\PaginatorInterface;



/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route ("/signin", name="signin")
     * @return Response
     */
    public function sign():Response
    {
        return $this->render('user/sign_in.html.twig');
    }

    /**
     * @Route ("/signup", name="signup")
     * @return Response
     */
    public function signup():Response
    {
        return $this->render('user/sign_in.html.twig');
    }

    /**
     * @Route ("/mail/{id}", name="mail", methods={"GET"})
     * @param $user
     * @param \Swift_Mailer $mailer
     */
    public function mail(User $user, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('jjjj mail'))

            ->setFrom('princeps.ordre@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($this->renderView(
            // templates/emails/registration.html.twig
                'user/registration.html.twig',
                ['user' => $user]
            ),
                'text/html'
            )


        ;

        $mailer->send($message);
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
     }
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(User::class)->findAll();

        $users = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );

        return $this->render('user/table.html.twig', [
            'users' => $users,
        ]);

    }
    /**
     * @Route ("/password/{id}", name="password", methods={"GET", "POST"}))
     */
    public function passsa(Request $request,$id , EntityManagerInterface $entityManager, UserRepository $rep, UserPasswordEncoderInterface $encoder): Response
    {
        $user=$rep->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->add('password',RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'The password fields must match.',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],
        ]);
        $form->add('save',SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager->flush();

            return $this->redirectToRoute('user_show', [
                'user' => $user]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'f' => $form->createView(),
        ]);
    }


    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @param $builder
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder , \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user );
        $form->add('password',RepeatedType::class, [
        'type' => PasswordType::class,
        'invalid_message' => 'The password fields must match.',
        'options' => ['attr' => ['class' => 'password-field']],
        'required' => true,
        'first_options'  => ['label' => 'Password'],
        'second_options' => ['label' => 'Repeat Password'],
    ]);
        $form ->add('captchaCode', CaptchaType::class, array(
        'captchaConfig' => 'ExampleCaptchaUserRegistration',
        'constraints' => [
            new ValidCaptcha([
                'message' => 'Invalid captcha, please try again',
            ]),
        ],
    ));

        $form->add('save',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setFlag(0);
            $entityManager->persist($user);
            $entityManager->flush();
            $message = (new \Swift_Message('activation mail'))

                ->setFrom('princeps.ordre@gmail.com')
                ->setTo($user->getEmail())
                ->setBody($this->renderView(
                // templates/emails/registration.html.twig
                    'user/registration.html.twig',
                    ['user' => $user]
                ),
                    'text/html'
                )


            ;

            $mailer->send($message);

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/sign_up.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activate/{id}", name="activated", methods={"GET"})
     */
    public function activate(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setFlag(1);
        $entityManager->flush();
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/edit/{id}", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,$id , EntityManagerInterface $entityManager, UserRepository $rep, UserPasswordEncoderInterface $encoder): Response
    {
        $user=$rep->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->add('role');
        $form->add('save',SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setId($id);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/update.html.twig', [
            'user' => $user,
            'f' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/ban/{id}", name="ban", methods={"POST"})
     */
    public function ban(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('ban'.$user->getId(), $request->request->get('_token'))) {
            $user->setFlag(0);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

}
