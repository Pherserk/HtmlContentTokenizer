<?php

namespace Tests\Components;


use Components\ContentBlockTokenizer;
use \PHPUnit_Framework_TestCase as BaseUnitTestCase;

class ContentBlockTokenizerTest extends BaseUnitTestCase
{
    /**
     * @dataProvider provideContent
     */
    public function testTokenize($content, $tokenizedContent)
    {
        $tokenizer = new ContentBlockTokenizer(['div', 'p'], [['ul', 'li'], ['ol', 'li'], ['table', 'tr']], ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']);

        self::assertEquals($tokenizedContent, $tokenizer->tokenize($content));
    }

    public function provideContent()
    {
        return [
            ['<div id="the-div"><h1>The div content</h1></div>', '[!#!BLOCK!#!][!#!BLOCK!#!][!#!HEAD!#!]The div content[#!#HEAD#!#][#!#BLOCK#!#][#!#BLOCK#!#]'],
            ['<div id="the-div">The div content</div>', '[!#!BLOCK!#!]The div content[#!#BLOCK#!#]'],
            ['<p id="the-paragraph">The paragraph content</p>', '[!#!BLOCK!#!]The paragraph content[#!#BLOCK#!#]'],
            ['<ol id="the-ordered-list"><li>Item 1</li><li>Item 2</li></ol>', '[!#!BLOCK!#!][!#!LIST!#!][!#!ITEM!#!]Item 1[#!#ITEM#!#][!#!ITEM!#!]Item 2[#!#ITEM#!#][#!#LIST#!#][#!#BLOCK#!#]'],
        ];
    }
}
