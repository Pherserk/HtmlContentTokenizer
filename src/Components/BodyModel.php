<?php

namespace Components;

class BodyModel
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }
    
    public function getContent()
    {
        return $this->content;
    }
}
