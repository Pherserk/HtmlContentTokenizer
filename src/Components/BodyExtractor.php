<?php

namespace Components;


class BodyExtractor
{
    public function extract($htmlContent)
    {
        $bodies = [];

        $htmlContent = preg_replace('/<head[^>]*>(.*?)<\/head>/is', '', $htmlContent);
        $htmlContent = preg_replace('/<script[^>]*>(.*?)<\/script>/is', '', $htmlContent);
        $htmlContent = preg_replace('/<style[^>]*>(.*?)<\/style>/is', '', $htmlContent);

        if (preg_match_all('/<body[^>]*>(.*?)<\/body>/is' , $htmlContent, $bodyContents) > 0) {
            foreach ($bodyContents[1] as $bodyContent) {
                $bodies[] = new BodyModel($bodyContent);
            }
        } else {
            $htmlContent = preg_replace('/<body[^>]*>(.*?)<\/body>/is', '', $htmlContent);

            if (preg_match('/<html[^>]*>(.*?)<\/html>/is' , $htmlContent, $bodyContents) > 0) {
                $bodies[] = new BodyModel($bodyContents[1]);
            } else {
                $bodies[] = new BodyModel($htmlContent);
            }
        }

        return $bodies;
    }
}
