<?php
namespace Myspace\BookmarkBundle\Services;

/**
 * Created by PhpStorm.
 * User: hnguyenhuu
 * Date: 2/6/17
 * Time: 11:33 AM
 */
class StringService
{
    public function getListKeywords($str, $minKeywordLength = 2)
    {
        if($str == null || $str == ''){
            return [];
        }

        $keywords = mb_split('[\s;\.\?,]+', $str);
        $keywords = array_filter($keywords, function ($keyword) use ($minKeywordLength) {
            return !empty($keyword) && strlen($keyword) > $minKeywordLength;
        });

        $keywords = array_unique($keywords);
        return $keywords;
    }
}