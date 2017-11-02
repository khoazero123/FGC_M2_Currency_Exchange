<?php
namespace FGC\CurrencyExchange\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Commands extends Command {
    protected $connection;
    protected $tableName;
    protected function configure() {
        $this->setName('fgc:currency-exchange')->setDescription('Import list rate.');
        $this->addArgument('action', InputArgument::REQUIRED, 'Type action'); // #1, REQUIRED | OPTIONAL bin/magento fgc:currency-exchange:import file
        $this->addArgument('file', InputArgument::OPTIONAL, 'path to file csv'); // #2
        //$this->addOption('file', 'f', InputOption::VALUE_REQUIRED, '', getcwd()); // bin/magento fgc:currency-exchange:import file -p "value"
    }
 
    protected function execute(InputInterface $input, OutputInterface $output) { // <info> <comment> <question> <error>
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $this->connection = $resource->getConnection();
        $this->tableName = $resource->getTableName('fgc_currencies'); 
        
        $action = $input->getArgument('action'); // getArgument | getOption
        $output->writeln('<info>Action: '.$action.'</info>');$output->writeln('');
        switch ($action) {
            case 'list':
                $sql = "Select * FROM " . $this->tableName;
                $result = $this->connection->fetchAll($sql);
                $output->writeln(json_encode($result,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
                break;
                case 'import':
                $file = $input->getArgument('file');
                if(!file_exists($file)) {$output->writeln('<error>File '.$file.' not found!</error>');return;}
                $this->FgcCurrencyExchangeImport($file);
                break;
            case 'update':
                $this->FgcCurrencyExchangeUpdate();
                break;
            default:
                $output->writeln('<info>No action to process</info>');
        }

    }
    protected function FgcCurrencyExchangeUpdate($file) {
        
    }
    protected function FgcCurrencyExchangeImport($file) {
        $run_start = microtime(true);
        $row = 0;
        if (($handle = fopen($file, "r")) !== FALSE) {
            $index_country_code = 0; $index_country_name = 1;
            $index_currency_code = 2; $index_currency_name = 3; $index_currency_rate = 4;

            $total_update_success = $total_update_fail = 0;
            $sql = "INSERT INTO `{$this->tableName}` (country_code,country_name,currency_code,currency_name,rate) VALUES ";
            $sqls = [];
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if($row===1) {
                    /* find column position */
                    $fields = count($data);
                    for ($c=0; $c < $fields; $c++) {
                        if(preg_match('/country_code/is',$data[$c]))    $index_country_code = $c;
                        if(preg_match('/country_name/is',$data[$c]))    $index_country_name = $c;
                        if(preg_match('/currency_code/is',$data[$c]))   $index_currency_code = $c;
                        if(preg_match('/currency_name/is',$data[$c]))   $index_currency_name = $c;
                        if(preg_match('/rate/is',$data[$c]))            $index_currency_rate = $c;                        
                    }
                } else {
                    $country_code = isset($data[$index_country_code]) ? trim($data[$index_country_code]) : '';
                    $country_name = isset($data[$index_country_name]) ? trim($data[$index_country_name]) : '';
                    $currency_code = isset($data[$index_currency_code]) ? trim($data[$index_currency_code]) : '';
                    $currency_name = isset($data[$index_currency_name]) ? trim($data[$index_currency_name]) : '';
                    $rate = isset($data[$index_currency_rate]) ? trim($data[$index_currency_rate]) : '1';

                    $sqls[] = "('$country_code','$country_name','$currency_code','$currency_name','$rate')";
                    if (true) {
                        //echo ($row-1)." ".$country_name." ($country_code) - $currency_name ($currency_code)" . "\n";
                        $total_update_success++;
                    } else {
                        $total_update_fail++;
                        //echo ($row-1).": Product " . $id . " Doesnt Exist \n";
                    }
                    echo "\n";
                }
            }
            if(!empty($sqls)) {
                /* // Delete old table
                $sql = "DROP TABLE IF EXISTS `{$this->tableName}`;";
                if($this->connection->query($sql)) {
                    $sql = "CREATE TABLE `{$this->tableName}` (
                        `country_code` varchar(4) NOT NULL COMMENT 'Country Code',
                        `currency_name` varchar(255) DEFAULT NULL COMMENT 'Country Name',
                        `currency_code` varchar(4) NOT NULL COMMENT 'Currency Code',
                        `country_name` varchar(255) DEFAULT NULL COMMENT 'Country Name',
                        `rate` float NOT NULL DEFAULT '1' COMMENT 'Currency Rate'
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Currencies table';";
                    if(!$this->connection->query($sql)) $output->writeln('<error>Cannot excute sql</error>');
                } */
                $sql = "TRUNCATE `{$this->tableName}`;";
                $this->connection->query($sql);

                $sql .= implode(', ',$sqls).';';
                //echo $sql."\n";
                if($this->connection->query($sql)) {
                    echo "Import success\n";
                } else echo "Import fail\n";
            }
            fclose($handle);
            $time_elapsed_secs = microtime(true) - $run_start;
            echo "Products was update success: $total_update_success \n";
            echo "Products was update fail   : $total_update_fail \n";
            echo "Run script finished in ".$time_elapsed_secs."s\n";
        }
    }
 
}
?>