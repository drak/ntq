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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/getExtensions", methods = {"GET"}, options={"expose"=true})
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
