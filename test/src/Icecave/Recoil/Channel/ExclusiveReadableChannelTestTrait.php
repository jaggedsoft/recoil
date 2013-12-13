<?php
namespace Icecave\Recoil\Channel;

use Exception;
use Icecave\Recoil\Channel\Exception\ChannelLockedException;
use Icecave\Recoil\Kernel\Kernel;
use Icecave\Recoil\Recoil;

trait ExclusiveReadableChannelTestTrait
{
    public function testReadWhenLocked()
    {
        $reader = function () {
            $this->setExpectedException(ChannelLockedException::CLASS);
            yield $this->channel->read();
        };

        $this->kernel->execute($this->channel->read());
        $this->kernel->execute($reader());
        $this->kernel->eventLoop()->run();
    }
}