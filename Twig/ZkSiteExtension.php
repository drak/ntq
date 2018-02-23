<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - http://zikula.org/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\ZkSiteTheme\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\ZkSiteTheme\Helper\ExtensionsListHelper;

class ZkSiteExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ExtensionsListHelper
     */
    protected $listHelper;

    public function __construct(RequestStack $requestStack, ExtensionsListHelper $listHelper)
    {
        $this->requestStack = $requestStack;
        $this->listHelper = $listHelper;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getGitHubRepositories', [$this, 'getGitHubRepositories'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('getFollowLinks', [$this, 'getFollowLinks'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('getExternalMedia', [$this, 'getExternalMedia'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Renders a list of GitHub repositories.
     *
     * @return string Output
     */
    public function getGitHubRepositories()
    {
        return '<div id="extensionsListContainer">' . $this->listHelper->renderGitHubRepositories() . '</div>';
    }

    /**
     * Renders follow links.
     *
     * @return string Output
     */
    public function getFollowLinks()
    {
        $output = '';
        $output .= '<ul class="list-inline">';
        $output .= '<li><a href="https://twitter.com/TheZikulan" title="Zikula @ Twitter"><i class="fa fa-fw fa-2x fa-twitter"></i></a></li>';
        $output .= '<li><a href="https://www.facebook.com/zikula" title="Zikula @ Facebook"><i class="fa fa-fw fa-2x fa-facebook"></i></a></li>';
        $request = $this->requestStack->getCurrentRequest();
        $output .= '<li><a href="/' . (null !== $request ? $request->getLocale() : 'en') . '/news/messages/view/createdDate/desc/1/10.rss" title="RSS" target="_blank"><i class="fa fa-fw fa-2x fa-rss"></i></a></li>';
        $output .= '</ul>';

        return $output;
    }

    /**
     * Renders related media from other sites.
     *
     * @return string Output
     */
    public function getExternalMedia()
    {
        $output = '';
        $output .= '<div class="row">';
        $output .= '<div class="col-sm-12">';
        $output .= '<h3 id="videoHeading" class="hidden"><i class="fa fa-youtube-play"></i> Videos</h3>';
        $request = $this->requestStack->getCurrentRequest();
        $locale = null !== $request ? $request->getLocale() : 'en';
        $playlist = $locale == 'de' ? 'PLN7cKDJMVZ6nambVMwU3JOFp72MPa2MYO' : 'PLN7cKDJMVZ6lQX5KMNoSxRBd8D5hSax1l';
        $output .= '<div id="videoFrame"></div>';
        $output .= '<span id="playlistId" class="hidden">' . $playlist . '</span>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
