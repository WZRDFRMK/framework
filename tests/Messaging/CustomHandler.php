<?php

namespace WZRD\Test\Messaging;

use WZRD\Messaging\Handler;

class CustomHandler extends Handler
{
    public function process(CustomMessage $message)
    {
        return 'ok';
    }
}
