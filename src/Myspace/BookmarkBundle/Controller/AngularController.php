<?php

namespace Myspace\BookmarkBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class AngularController extends FOSRestController
{
    /**
     * @return mixed
     * @ApiDoc(
     *     section="Angular services",
     *     description="Get user profile",
     *     statusCodes={
     *       200 = "Returned when successful",
     *       401 = "Returned when authenticate faith"
     *     },
     * ),
     */
    public function getAngularsAction()
    {
        $angularReadMe = 'https://raw.githubusercontent.com/angular/angular/master/CHANGELOG.md';
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $angularReadMe);
        $body = $res->getBody()->getContents();
        $lines = explode("\n", $body);
        $versions = [];
        $versionReg = '/<a\s*name\s*=\s*"([^"]*)"/';
        $featureReg = '/###\s*((.?)*)/';
        $dataReg = '/\(([^\)]*)\)/';
        foreach ($lines as $line) {
            if(strpos($line, '<a name="') === 0) {
                $currentFeature = '';
                preg_match($versionReg, $line, $versionMatch);
                $currentVersion = $versionMatch[1];
                if(!isset($versions[$currentVersion])) {
                    $versions[$currentVersion] = [];
                }
            }

            if (strpos($line, "# ") === 0 || strpos($line, "## ") === 0) {
                $currentFeature = '';
                $matchCount = preg_match_all($dataReg, $line, $datas);
                if($matchCount > 0) {
                    $versions[$currentVersion]['url'] = $this->getUrlInArray($datas[1]);
                    $versions[$currentVersion]['date'] = $this->getDateInArray($datas[1]);
                }
            }

            if (strpos($line, "### ") === 0) {
                preg_match($featureReg, $line, $featureMatch);
                $currentFeature = $featureMatch[1];
                $versions[$currentVersion]['features'][$currentFeature] = [];
            }

            if (strpos($line, '* ') === 0) {
                $links = $this->getMarkdownLinks($line);
                $links['text'] = $this->removeTags($links['text']);
                $links['tags'] = $this->getTags($line);
                $links['isBug'] = 'Bug Fixes' === $currentFeature;
                $versions[$currentVersion]['features'][$currentFeature][] = $links;

            }
        }
        return ['versions' => $versions];
    }

    private function isUrl($url) {
        if(strpos($url, 'http://') === 0
            || strpos($url, 'https://') === 0
            || strpos($url, '://') === 0
        ) {
            return true;
        }

        return false;
    }

    private function getUrlInArray($array) {
        foreach ($array as $value) {
            if ($this->isUrl($value)) {
                return $value;
            }
        }

        return '';
    }

    private function getDateInArray($array) {
        foreach ($array as $value) {
            if ($this->validateDate($value)) {
                return $value;
            }
        }
    }

    private function validateDate($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    private function getTags($text) {
        $tagReg = '/\*\*([^*:]*):\*\*/';
        $matchCount = preg_match_all($tagReg, $text, $datas);
        if($matchCount > 0) {
            return $datas[1];
        }
    }

    private function removeTags($text) {
        $tagReg = '/\*\*([^*:]*):\*\*/';
        $result = preg_replace($tagReg, '', $text);
        return str_replace('()', '', $result);
    }

    private function getMarkdownLinks ($text) {
        $reg = '/\[([^]]*)\] *\(([^)]*)\)/i';
        $matchCount = preg_match_all($reg, $text, $datas);
        $newText = preg_replace($reg, '', $text);
        $result = ['text' => $newText, 'urls' => []];
        if($matchCount > 0) {
            foreach ($datas[1] as $index => $id) {
                $result['urls'][] = ['text' => $id, 'url' => $datas[2][$index]];
            }
        }

        return $result;
    }
}
