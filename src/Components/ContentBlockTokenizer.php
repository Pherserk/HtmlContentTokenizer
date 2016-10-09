<?php

namespace Components;


class ContentBlockTokenizer
{
    const OPENING_BLOCK = '[!#!BLOCK!#!]';
    const CLOSING_BLOCK = '[#!#BLOCK#!#]';
    const OPENING_HEADING = '[!#!HEAD!#!]';
    const CLOSING_HEADING = '[#!#HEAD#!#]';
    const OPENING_LIST = '[!#!LIST!#!]';
    const CLOSING_LIST = '[#!#LIST#!#]';
    const OPENING_ITEM = '[!#!ITEM!#!]';
    const CLOSING_ITEM = '[#!#ITEM#!#]';


    /** @var string[] */
    private $blockTags;
    /** @var string[] */
    private $listTags;
    /** @var string[] */
    private $headingTags;

    public function __construct(array $blockTags, array $listTags, array $headingTags)
    {
        $this->headingTags = $headingTags;
        $this->listTags = $listTags;
        $this->blockTags = $blockTags;
    }


    public function tokenize($htmlContent)
    {
        foreach($this->blockTags as $blockTag) {
            $openingRegex = sprintf('/<%s[^>]*>/is', $blockTag);
            $closingRegex = sprintf('/<\/%s>/is', $blockTag);

            $htmlContent = preg_replace($openingRegex, self::OPENING_BLOCK, $htmlContent);
            $htmlContent = preg_replace($closingRegex, self::CLOSING_BLOCK, $htmlContent);
        }

        foreach($this->listTags as $listTag) {
            $openingRegex = sprintf('/<%s[^>]*>/is', $listTag[0]);
            $closingRegex = sprintf('/<\/%s>/is', $listTag[0]);

            $htmlContent = preg_replace($openingRegex, self::OPENING_BLOCK . self::OPENING_LIST, $htmlContent);
            $htmlContent = preg_replace($closingRegex, self::CLOSING_LIST . self::CLOSING_BLOCK, $htmlContent);

            $openingItemRegex = sprintf('/<%s[^>]*>/is', $listTag[1]);
            $closingItemRegex = sprintf('/<\/%s>/is', $listTag[1]);

            $htmlContent = preg_replace($openingItemRegex, self::OPENING_ITEM, $htmlContent);
            $htmlContent = preg_replace($closingItemRegex, self::CLOSING_ITEM, $htmlContent);
        }

        foreach($this->headingTags as $headingTag) {
            $openingRegex = sprintf('/<%s[^>]*>/is', $headingTag);
            $closingRegex = sprintf('/<\/%s>/is', $headingTag);

            $htmlContent = preg_replace($openingRegex, self::OPENING_BLOCK . self::OPENING_HEADING, $htmlContent);
            $htmlContent = preg_replace($closingRegex, self::CLOSING_HEADING . self::CLOSING_BLOCK, $htmlContent);
        }

        return $htmlContent;
    }
}
