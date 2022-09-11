<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\User;
use App\Form\UserType;
use App\Service\OrgManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{index}/user", name="app_organization_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, OrgManager $orgManager, int $index): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'attr' => [
                'id' => 'user_form',
                'novalidate' => 'novalidate'
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $organizationArray = $orgManager->getOrganization($index);
            $organization = new Organization();
            $organization->setName($organizationArray['name']);
            $organization->setDescription($organizationArray['description']);
            $organization->setUsers($organizationArray['users']);
            $organization->addUser($user->__toArray());
            $orgManager->update($organization->__toArray(), $index);
            $this->addFlash('success', 'User saved successfully !');

            return $this->redirectToRoute('app_organization_show', ['index' => $index]);
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
            'index' => $index
        ]);
    }

    /**
     * @Route("/edit/{userIndex}", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OrgManager $orgManager, int $index, int $userIndex): Response
    {
        $organizationArray = $orgManager->getOrganization($index);

        $organization = new Organization();
        $organization->setName($organizationArray['name']);
        $organization->setDescription($organizationArray['description']);
        $organization->setUsers($organizationArray['users']);

        $userArray = $organization->getUsers()[$userIndex];
        $user = new User();
        $user->setName($userArray['name']);
        $user->setPassword($userArray['password']);
        $user->setRole($userArray['role']);

        $form = $this->createForm(UserType::class, $user, [
            'attr' => [
                'id' => 'user_form',
                'novalidate' => 'novalidate'
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $organization->setUser($user->__toArray(), $userIndex);
            $orgManager->update($organization->__toArray(), $index);
            $this->addFlash('success', 'User updated successfully !');

            return $this->redirectToRoute('app_organization_show', ['index' => $index]);
        }

        return $this->render('organization/edit.html.twig', [
            'form' => $form->createView(),
            'index' => $index
        ]);
    }

    /**
     * @Route("/delete/{userIndex}", name="delete", methods={"POST"})
     */
    public function delete(int $index, int $userIndex, Request $request, OrgManager $orgManager): Response
    {
        if ($this->isCsrfTokenValid("delete-$index-$userIndex", $request->request->get('token'))) {
            $organizationArray = $orgManager->getOrganization($index);
            $users = $organizationArray['users'];
            array_splice($users, $userIndex, 1);
            $organizationArray['users'] = $users;
            $orgManager->update($organizationArray, $index);
            $this->addFlash('success', 'User deleted successfully !');
        }
        return $this->redirectToRoute('app_organization_show', ['index' => $index]);
    }
}
