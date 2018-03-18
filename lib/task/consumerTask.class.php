<?php

class consumerTask extends sfBaseTask
{
    protected function configure()
    {
        // // add your own arguments here
        // $this->addArguments(array(
        //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
        // ));

        try {
            $this->addOptions(array(
                new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
                // add your own options here
            ));
        } catch (sfCommandException $e) {
            error_log($e->getMessage());
        }

        $this->name = 'consumer';
        $this->briefDescription = 'Runs RabbitMQ consumer task';
    }

    protected function execute($arguments = array(), $options = array())
    {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        try {
            $name = $options['connection'] ? $options['connection'] : null;
            $databaseManager->getDatabase($name)->getConnection();
        } catch (sfDatabaseException $e) {
            error_log($e->getMessage());
        }
        // add your code here
    }
}
