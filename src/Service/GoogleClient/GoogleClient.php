<?php

declare(strict_types=1);

namespace App\Service\GoogleClient;

use App\Interfaces\ExporterInterface;
use App\Service\GoogleClient\Exceptions\PermissionsErrorException;
use Google\Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_Permission;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use Psr\Log\LoggerInterface;

class GoogleClient implements ExporterInterface
{
    private string $projectDir;
    private LoggerInterface $logger;

    public function __construct(string $projectDir, LoggerInterface $logger)
    {
        $this->projectDir = $projectDir;
        $this->logger = $logger;
    }

    public function getClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS, Google_Service_Drive::DRIVE]);
        try {
            $client->setAuthConfig($this->projectDir . '/Cred.json');
        } catch (Exception $e) {
        }
        return $client;
    }

    public function getGoogleSheetsService(Google_Client $client): Google_Service_Sheets
    {
        return new Google_Service_Sheets($client);
    }

    public function getGoogleDriveService(Google_Client $client): Google_Service_Drive
    {
        return new Google_Service_Drive($client);
    }

    public function create(): string
    {
        $title = "Xml Datasheet";
        $client = $this->getClient();
        $service = $this->getGoogleSheetsService($client);
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => $title
            ]
        ]);
        $spreadsheet = $service->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);
        $this->setPermissions($spreadsheet->spreadsheetId);
        $this->logger->info(printf("Spreadsheet ID: %s\n", $spreadsheet->spreadsheetId));
        return $spreadsheet->spreadsheetId;
    }

    public function updateValues(string $spreadsheetId, array $values): void
    {
        $range = "Sheet1";
        $valueInputOption = "RAW";
        $client = $this->getClient();
        $service = $this->getGoogleSheetsService($client);

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => $valueInputOption
        ];
        $result = $service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            $params
        );
        $this->logger->info(printf("%d cells updated.", $result->getUpdates()->getUpdatedRows()));
    }

    private function setPermissions(string $spreadsheetId): void
    {
        $permission = new Google_Service_Drive_Permission();
        $permission->setType('anyone');
        $permission->setRole("reader");
        $client = $this->getClient();
        $service = $this->getGoogleDriveService($client);
        try {
            $service->permissions->create($spreadsheetId, $permission);
        } catch (Exception $e) {
            throw new PermissionsErrorException("Error setting permissions" . $e->getMessage());
        }
    }
}
