<?php

namespace App\GoogleClient;

use App\Interfaces\ExporterInterface;
use App\MappedXml\MappedXml;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_Permission;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use Psr\Log\LoggerInterface;


class GoogleClient implements ExporterInterface
{
    private $projectDir;
    private LoggerInterface $logger;

    public function __construct(string $projectDir, LoggerInterface $logger)
    {
        $this->projectDir = $projectDir;
        $this->logger = $logger;
    }

    public function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS, Google_Service_Drive::DRIVE]);
        $client->setAuthConfig($this->projectDir.'/Cred.json');

        return $client;
    }

    public function getGoogleSheetsService(Google_Client $client)
    {
        return new Google_Service_Sheets($client);

    }

    public function getGoogleDriveService(Google_Client $client)
    {
        return new Google_Service_Drive($client);

    }

    public function create($title)
    {
        $client = $this->getClient();
        $service = $this->getGoogleSheetsService($client);
        // [START sheets_create]
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => $title
            ]
        ]);
        $spreadsheet = $service->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);
        $this->logger->info(printf("Spreadsheet ID: %s\n", $spreadsheet->spreadsheetId));
        return $spreadsheet->spreadsheetId;
    }

    public function updateValues($spreadsheetId, $range, $valueInputOption,
                                 $values)
    {
        $client = $this->getClient();
        $service = $this->getGoogleSheetsService($client);

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => $valueInputOption
        ];
        $result = $service->spreadsheets_values->update($spreadsheetId, $range,
            $body, $params);
        $this->logger->info(printf("%d cells updated.", $result->getUpdatedCells()));
        return $result;
    }

    public function exportSheet(MappedXml $mappedXml): string
    {
        $spreadsheetId = $this->create("Xml datasheet");
        $range = "Sheet1";
        $valueInputOption = "RAW";
        $values = $mappedXml->getExportData();
        $this->updateValues(
            $spreadsheetId, $range, $valueInputOption, $values
        );
        $this->setPermissions($spreadsheetId);
        return $spreadsheetId;
    }

    private function setPermissions($spreadsheetId){
        $permission = new Google_Service_Drive_Permission();
        $permission->setType('anyone');
        $permission->setRole("reader");
        $client = $this->getClient();
        $service = $this->getGoogleDriveService($client);
        $service->permissions->create($spreadsheetId, $permission);

    }

}