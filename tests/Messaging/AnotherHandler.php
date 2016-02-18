<?php

namespace WZRD\Test\Messaging;

use WZRD\Messaging\Handler;

class AnotherHandler extends Handler
{
    public function process(BadMessage $message)
    {
        return 'boom';
    }
}
