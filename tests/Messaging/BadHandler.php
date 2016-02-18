<?php

namespace WZRD\Test\Messaging;

use WZRD\Messaging\Handler;

class BadHandler extends Handler
{
    public function bad_process_method(BadMessage $message)
    {
        return 'boom';
    }
}
