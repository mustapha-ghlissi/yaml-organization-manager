<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Form\OrganizationType;
use App\Service\OrgManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="app_organization_")
 */
class OrganizationController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(OrgManager $orgManager): Response
    {
        return $this->render('organization/index.html.twig', [
            'organizations' => $orgManager->getOrganizations(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, OrgManager $orgManager): Response
    {
        $organization = new Organization();
        $form = $this->createForm(OrganizationType::class, $organization, [
            'attr' => [
                'id' => 'organization_form',
                'novalidate' => 'novalidate'
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $orgManager->add($organization);
            $this->addFlash('success', 'Organization added successfully !');

            return $this->redirectToRoute('app_organization_index');
        }

        return $this->render('organization/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{index}", name="show", methods={"GET"})
     */
    public function show(Request $request, OrgManager $orgManager, int $index): Response
    {
        $organizationArray = $orgManager->getOrganization($index);

        return $this->render('organization/show.html.twig', [
            'organization' => $organizationArray,
            'index' => $index
        ]);
    }

    /**
     * @Route("/edit/{index}", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OrgManager $orgManager, int $index): Response
    {
        $organizationArray = $orgManager->getOrganization($index);

        $organization = new Organization();
        $organization->setName($organizationArray['name']);
        $organization->setDescription($organizationArray['description']);
        $organization->setUsers($organizationArray['users']);

        $form = $this->createForm(OrganizationType::class, $organization, [
            'attr' => [
                'id' => 'organization_form',
                'novalidate' => 'novalidate'
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $orgManager->update($organization->__toArray(), $index);
            $this->addFlash('success', 'Organization updated successfully !');

            return $this->redirectToRoute('app_organization_index');
        }

        return $this->render('organization/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{index}", name="delete", methods={"POST"})
     */
    public function delete(int $index, Request $request, OrgManager $orgManager): Response
    {
        if ($this->isCsrfTokenValid("delete-$index", $request->request->get('token'))) {
            $orgManager->delete($index);
            $this->addFlash('success', 'Organization deleted successfully !');
        }
        return $this->redirectToRoute('app_organization_index');
    }
}
