<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendTestEmailCommand extends Command
{
    // Supprimez cette ligne si elle cause des problèmes avec votre version de Symfony
    // protected static $defaultName = 'app:send-test-email';

    protected function configure()
    {
        $this
            ->setName('app:send-test-email') // Ajoutez cette ligne pour définir le nom de la commande
            ->setDescription('Send a test email.')
            ->setHelp('This command allows you to send a test email...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Logic to send email
        $output->writeln('Test email sent.');

        return Command::SUCCESS;
    }
}
