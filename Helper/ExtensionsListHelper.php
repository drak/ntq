<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - http://zikula.org/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\ZkSiteTheme\Helper;

use Zikula\Module\CoreManagerModule\Helper\ClientHelper;

class ExtensionsListHelper
{
    protected $clientHelper;
    protected $githubClient;

    public function __construct(ClientHelper $clientHelper)
    {
        include_once 'modules/Zikula/CoreManagerModule/vendor/autoload.php';

        $this->clientHelper = $clientHelper;
    }

    /**
     * Returns a list of GitHub repositories.
     *
     * @param string $searchTerm Optional search term
     *
     * @return string Output
     */
    public function renderGitHubRepositories($searchTerm = '')
    {
        $repos = $this->getGitHubRepositories(strtolower($searchTerm));

        $output = '';
        $output .= '<h3><i class="fa fa-cubes"></i> Extensions - ' . count($repos) . ' repositories found</h3>';
        $output .= '<p><small>Projects with no activity in the last two years are skipped.</small></p>';
        $output .= '<div id="extensionsFilterGroup" class="form-group hidden"><div class="input-group"><input type="search" id="extensionsFilter" placeholder="Filter" class="form-control" /><span class="input-group-btn"><button id="btnApplyFilter" class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span></div></div>';
        $counter = 0;
        foreach ($repos as $repo) {
            $counter = $counter == 3 ? 1 : $counter + 1;
            if ($counter == 1) {
                $output .= '<br class="hidden-xs" /><div class="row">';
            }
            $nameAttr = str_replace('"', '', $repo['name']);
            $loginAttr = str_replace('"', '', $repo['owner']['login']);
            $output .= '<div class="col-sm-4">'
                . '<div class="media">'
                . '  <div class="media-left">'
                . '    <a href="' . $repo['owner']['html_url'] . '" title="' . $loginAttr . '">'
                . '        <img src="' . $repo['owner']['avatar_url'] . '" alt="' . $loginAttr . '" width="64" class="media-object img-thumbnail" />'
                . '    </a>'
                . '  </div>'
                . '  <div class="media-body">'
                . '    <h4 class="media-heading"><a href="' . $repo['html_url'] . '" title="' . $nameAttr . ' @ GitHub"><i class="fa fa-fw fa-github"></i>' . $repo['name'] . '</a></h4>'
                . '    <p>' . substr($repo['description'], 0, 100) . '&hellip;</p>'
                . '  </div>'
                . '</div>'
                . '</div>';
            if ($counter == 3) {
                $output .= '</div>';
            }
        }
        if ($counter != 3) {
            $output .= '</div>';
        }

        return $output;
    }

    /**
     * Returns a list of GitHub repositories.
     *
     * @param string $searchTerm Optional search term
     *
     * @return array List of repositories
     */
    private function getGitHubRepositories($searchTerm = '')
    {
        $result = $this->loadGitHubRepositories();

        $repos = [];
        $thresholdDate = new \DateTime();
        $thresholdDate->sub(new \DateInterval('P2Y'));
        $thresholdDate = $thresholdDate->format('Y-m-d');
        foreach ($result as $repo) {
            if ($repo['fork'] || $repo['private']) {
                continue;
            }
            if ($repo['owner']['login'] == 'zikula' && !in_array($repo['name'], ['SpecModule', 'SpecTheme'])) {
                continue;
            }
            $updatedDate = $repo['pushed_at'];
            /*$updatedDate = $repo['updated_at'];
            if ($repo['pushed_at'] > $updatedDate) {
                $updatedDate = $repo['pushed_at'];
            }*/
            if ($updatedDate < $thresholdDate) {
                continue;
            }

            if (empty($searchTerm)) {
                $repos[] = $repo;
            } else {
                if (false !== strpos(strtolower($repo['owner']['login']), $searchTerm)
                    || false !== strpos(strtolower($repo['name']), $searchTerm)
                    || false !== strpos(strtolower($repo['description']), $searchTerm)
                ) {
                    $repos[] = $repo;
                }
            }
        }

        usort($repos, function($a, $b) {
            if (strtolower($a['name']) == strtolower($b['name'])) {
                return 0;
            }
            return strtolower($a['name']) < strtolower($b['name']) ? -1 : 1;
        });

        return $repos;
    }

    /**
     * Loads repositories list from GitHub.
     *
     * @return array List of repositories
     */
    private function loadGitHubRepositories()
    {
        $cacheFile = 'web/uploads/github_extension_repositories.json';
        $refetch = false;
        if (!file_exists($cacheFile)) {
            $refetch = true;
        } else {
            $compareDate = date('Y-m-d H:i:s', filectime($cacheFile));
            $thresholdDate = new \DateTime();
            $thresholdDate->sub(new \DateInterval('PT2H'));
            $thresholdDate = $thresholdDate->format('Y-m-d H:i:s');
            if ($compareDate < $thresholdDate) {
                unlink($cacheFile);
                $refetch = true;
            }
        }

        if (true !== $refetch) {
            $result = json_decode(file_get_contents($cacheFile), true);
        } else {
            $this->githubClient = $this->clientHelper->getGitHubClient(false);

            $searchApi = $this->githubClient->api('search');
            $searchTerm = 'zikula'; // topic:zikula
            //$result = $searchApi->repositories($searchTerm);//, 'updated', 'desc');

            $paginator = new \Github\ResultPager($this->githubClient);
            $result = $paginator->fetchAll($searchApi, 'repositories', [$searchTerm/*, 'updated', 'asc'*/]);

            if (false === $result || empty($result)) {
                $result = [];
            }

            file_put_contents($cacheFile, json_encode($result));
        }

        return $result;
    }
}
