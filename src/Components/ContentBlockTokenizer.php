<?php

namespace Components;


class ContentBlockTokenizer
{
    const OPENING_TOKEN = '[!#!BLOCK!#!]';
    const CLOSING_TOKEN = '[#!#BLOCK#!#]';
    const OPENING_HEADING = '[!#!HEAD!#!]';
    const CLOSING_HEADING = '[#!#HEAD#!#]';


    /** @var string[] */
    private $blockTags;

    public function __construct(array $blockTags, array $headingTags)
    {
        $this->headingTags = $headingTags;
        $this->blockTags = $blockTags;
    }


    public function tokenize($htmlContent)
    {
        foreach($this->headingTags as $headingTag) {
            $openingRegex = sprintf('/<%s[^>]*>/is', $headingTag);
            $closingRegex = sprintf('/<\/%s>/is', $headingTag);

            $htmlContent = preg_replace($openingRegex, self::OPENING_TOKEN . self::OPENING_HEADING, $htmlContent);
            $htmlContent = preg_replace($closingRegex, self::CLOSING_HEADING . self::CLOSING_TOKEN, $htmlContent);
        }

        foreach($this->blockTags as $blockTag) {
            $openingRegex = sprintf('/<%s[^>]*>/is', $blockTag);
            $closingRegex = sprintf('/<\/%s>/is', $blockTag);

            $htmlContent = preg_replace($openingRegex, self::OPENING_TOKEN, $htmlContent);
            $htmlContent = preg_replace($closingRegex, self::CLOSING_TOKEN, $htmlContent);
        }

        return $htmlContent;
    }
}
