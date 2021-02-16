<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class importprices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:prices {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a CSV file into Prices DB table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $filename = $this->argument('filename');
            if (!$filename) {
                throw new \Exception("File name not informed!", 1001);
            }

            $detailedLog = env('DETAILED_IMPORT_LOG', false);
            $handle = fopen($filename, "r");

            if ($handle) {
                // reads the header and identifies each field index for further use
                if (($line = fgets($handle)) !== false) {
                    $fieldIndexes = array_flip(explode(',', trim($line)));
                } else {
                    throw new \Exception("Unexpected end of file!", 1002);
                }

                $this->validateHeader($fieldIndexes);

                while (($line = fgets($handle)) !== false) {
                    $data = explode(',', trim($line));

                    $importResult = DB::selectOne('call importPrices(?,?,?,?,?)', [
                        $data[$fieldIndexes['sku']],
                        $data[$fieldIndexes['account_ref']],
                        $data[$fieldIndexes['user_ref']],
                        intval($data[$fieldIndexes['quantity']]),
                        doubleval($data[$fieldIndexes['value']])
                    ]);

                    /**
                     * we may want to log all, just the rejected ones, or even none, depending on business needs
                     */ 
                    if ($detailedLog) {
                        Log::info('Import results', [
                            'code' => $importResult->code, 
                            'message' => $importResult->message
                        ]);
                    }
                }
            }        
        } catch (\Throwable $e) {
            Log::error('Import error', [
                'code' => $e->getCode(), 
                'message' => $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine()
            ]);
        } finally {
            if ($handle) {
                fclose($handle);
            }
        }
    }

    /**
     * Validates the header
     * @param array
     */
    private function validateHeader(array $fields) {
        if (!isset($fields['sku'])
            || !isset($fields['account_ref'])
            || !isset($fields['user_ref'])
            || !isset($fields['quantity'])
            || !isset($fields['value'])) {
            throw new \Exception("Invalid file header!", 1003);
        }
    }
}
