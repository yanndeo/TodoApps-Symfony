<?php

namespace App\Command;

use App\service\Reminder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReminderCommand extends Command
{
    protected static $defaultName = 'app:reminder';

    /**
     * @var Reminder
     */
    protected  $reminder;


    /**
     * ReminderCommand constructor.
     * @param null $name
     * @param Reminder $reminder
     */
    public function __construct( $name = null, Reminder $reminder)
    {
        parent::__construct($name);

        $this->reminder = $reminder;
    }




    protected function configure()
    {
        $this
            ->setDescription('Envoie aux utilisateurs les rappels de leurs tâche')
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $output->writeln([
            'Reminder',
            '============',
            '',
        ]);

        $reminds=  $this->reminder->remind();

        $io->success($reminds . ' les rappels ont été envoyé');
    }
}
