<?php

namespace tests\functional;

use app\console\fixtures\StaticPageFixture;

abstract class _BeforeRun
{
    public function _fixtures()
    {
        return [
            'static_page' => [
                'class'    => StaticPageFixture::class,
            ],
        ];
    }
}
