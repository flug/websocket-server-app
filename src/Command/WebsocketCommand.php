<?php
namespace Clooder\Command;

use Clooder\Process\MessageProcess;
use Clooder\Subscriber\SocketSubscriber;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\NullLogger;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class WebsocketCommand extends Command
{
    protected function configure()
    {
        $this->setName('socket')
            ->addArgument('host', InputArgument::OPTIONAL, "host listener",
                "localhost")
            ->addArgument('port', InputArgument::OPTIONAL, "port listener",
                8863)
            ->addOption('with-log', 'wl', InputOption::VALUE_OPTIONAL,
                'stream logs default [true]', true)
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new SocketSubscriber());
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new MessageProcess(
                        $this->getLogger($input),
                        $dispatcher
                    )
                )
            ),
            $input->getArgument('port'),
            $input->getArgument('host')
        );
        $output->writeln(sprintf(' // Executing chat socket on : %s : %s ',
            $input->getArgument('host'), $input->getArgument('port')));
        $server->run();
        
    }
    
    private function getLogger(InputInterface $input)
    {
        if ((bool)$input->getOption('with-log')) {
            $logger = new Logger('websocket');
            $logger->pushHandler(new StreamHandler(\ConsoleKernel::getRootKernel() . '/../log/socket.log'));
        } else {
            $logger = new NullLogger();
        }
        
        return $logger;
    }
}
