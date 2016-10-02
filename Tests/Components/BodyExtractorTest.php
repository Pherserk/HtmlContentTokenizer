<?php

namespace Tests\Components;

use Components\BodyExtractor;
use Components\BodyModel;
use \PHPUnit_Framework_TestCase as BaseUnitTestCase;

class BodyExtractorTest extends BaseUnitTestCase
{
    public function testExtract()
    {
        $htmlDocumentContent = <<<CONTENT
<html>
    <head>
        <title>A title tag for a well formed document with one only body</title>
    </head>
    <body>
        <h1>Some interesting content</h1>
        <p>This is the content, there is one only body tag</p>
    </body>
</html>
CONTENT;

        $expectedBodyContent = <<<BODY_CONTENT
        <h1>Some interesting content</h1>
        <p>This is the content, there is one only body tag</p>
BODY_CONTENT;


        $extractor = new BodyExtractor();
        /** @var BodyModel[] $bodies */
        $bodies = $extractor->extract($htmlDocumentContent);

        self::assertCount(1, $bodies);
        self::assertEquals(trim($expectedBodyContent), trim($bodies[0]->getContent()));
    }

    public function testExtract_no_body_tag()
    {
        $htmlDocumentContent = <<<CONTENT
<html>
    <head>
        <title>A title tag, for a document without body</title>
    </head>
    Content of a document with spare tags
    <p>Other content and <strong>so on</strong></p>
    <br>
    End of content.
</html>
CONTENT;

        $expectedBodyContent = <<<BODY_CONTENT
    Content of a document with spare tags
    <p>Other content and <strong>so on</strong></p>
    <br>
    End of content.
BODY_CONTENT;

        $extractor = new BodyExtractor();
        /** @var BodyModel[] $bodies */
        $bodies = $extractor->extract($htmlDocumentContent);

        self::assertCount(1, $bodies);
        self::assertEquals(trim($expectedBodyContent), trim($bodies[0]->getContent()));
    }

    public function testExtract_multiple_body_tags()
    {
        $htmlDocumentContent = <<<CONTENT
<html>
    <head>
    </head>
    <body>
        This body contains some content.
        <div></div>
    </body>
    <body>
        Some content of course in this second body tag
    </body>
</html>
CONTENT;

        $expectedBodyContent = <<<BODY_CONTENT
        This body contains some content.
        <div></div>
BODY_CONTENT;

        $expectedBodyContent2 = <<<BODY_CONTENT2
        Some content of course in this second body tag
BODY_CONTENT2;

        $extractor = new BodyExtractor();
        /** @var BodyModel[] $bodies */
        $bodies = $extractor->extract($htmlDocumentContent);

        self::assertCount(2, $bodies);
        self::assertEquals(trim($expectedBodyContent), trim($bodies[0]->getContent()));
        self::assertEquals(trim($expectedBodyContent2), trim($bodies[1]->getContent()));

    }
}
