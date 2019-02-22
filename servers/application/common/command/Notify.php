<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/15
 * Time: 13:49
 */

namespace app\common\command;


use app\common\service\RedisSubscribe;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class Notify extends Command
{
    protected function configure()
    {
        $this->setName('pay')
            ->addArgument('type', Argument::REQUIRED, "the type of the task that pay needs to run")
            ->setDescription('this is payment system command line tools');
    }


    protected function execute(Input $input, Output $output)
    {
        $type = $input->getArgument('type');
        if ($type == 'psubscribe') {
            // 发布订阅任务
            $this->psubscribe();
        }
        $output->writeln("TestCommand:");
    }


    /**
     * Redis 发布订阅模式
     */
    private function psubscribe()
    {
        $service = new RedisSubscribe();
        $service->sub();
    }
}