<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - http://zikula.org/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\ZkSiteTheme\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zikula\Core\Controller\AbstractController;
use Zikula\ZkSiteTheme\Helper\ExtensionsListHelper;

/**
 * @Route("/ajax")
 */
class AjaxController extends AbstractController
{
    /**
     * Returns list of extension repositories.
     *
     * @Route("/getExtensions", options={"expose"=true})
     * @Method("GET")
     *
     * @return Response
     */
    public function getExtensionsAction(Request $request)
    {
        $searchTerm = $request->query->get('searchTerm', '');

        $listHelper = $this->get('zikula_zksite_theme.extensions_list_helper');

        return new Response($listHelper->renderGitHubRepositories($searchTerm));
    }
}
