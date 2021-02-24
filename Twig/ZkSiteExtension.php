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
use Zikula\ZkSiteTheme\Helper\GitHubIntegrationHelper;

class ZkSiteExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var GitHubIntegrationHelper
     */
    protected $githubHelper;

    public function __construct(RequestStack $requestStack, GitHubIntegrationHelper $githubHelper)
    {
        $this->requestStack = $requestStack;
        $this->githubHelper = $githubHelper;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('ghRepositories', [$this, 'getGitHubRepositories'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('ghDiscussions', [$this, 'getGitHubDiscussions'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('getFollowLinks', [$this, 'getFollowLinks'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Renders a list of GitHub repositories.
     *
     * @return string Output
     */
    public function getGitHubRepositories()
    {
        return '<div id="extensionsListContainer">' . $this->githubHelper->renderRepositories() . '</div>';
    }

    /**
     * Renders a list of GitHub discussions.
     *
     * @param int $amount Amount of discussions to be shown
     *
     * @return string Output
     */
    public function getGitHubDiscussions($amount = 10)
    {
        return '<div id="discussionListContainer">' . $this->githubHelper->renderDiscussions($amount) . '</div>';
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
}
