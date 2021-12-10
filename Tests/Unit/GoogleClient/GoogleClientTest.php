<?php

declare(strict_types=1);

namespace App\Tests\Unit\GoogleClient;

use PHPUnit\Framework\TestCase;
use App\GoogleClient\GoogleClient;
use Google\Service\Sheets\UpdateValuesResponse;
use Google_Service_Drive;
use Google_Service_Drive_Permission;
use Google_Service_Drive_Resource_Permissions;
use Google_Service_Sheets;
use Google_Service_Sheets_Resource_Spreadsheets;
use Google_Service_Sheets_Resource_SpreadsheetsValues;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use App\Tests\DataProvider\DataProvider;


class GoogleClientTest extends TestCase
{
    /**
     * @var Google_Service_Sheets|mixed|MockObject
     */
    private $googleSheetServiceMock;

    /**
     * @var Google_Service_Sheets_Resource_Spreadsheets|mixed|MockObject
     */
    private $sheetResourceMock;

    /**
     * @var mixed|MockObject|LoggerInterface
     */
    private $loggerMock;

    /**
     * @var Google_Service_Drive|mixed|MockObject
     */
    private $driveServiceMock;

    /**
     * @var Google_Service_Drive_Resource_Permissions|mixed|MockObject
     */
    private $drivePermissionResourceMock;

    /**
     * @var Google_Service_Sheets_Resource_SpreadsheetsValues|mixed|MockObject
     */
    private $spreadsheetsValuesResourceMock;

    /**
     * @var DataProvider
     */
    private $dataProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->googleSheetServiceMock = $this->createMock(Google_Service_Sheets::class);
        $this->driveServiceMock = $this->createMock(Google_Service_Drive::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->drivePermissionResourceMock = $this->createMock(Google_Service_Drive_Resource_Permissions::class);
        $this->driveServiceMock->permissions = $this->drivePermissionResourceMock;

        $this->sheetResourceMock = $this->createMock(Google_Service_Sheets_Resource_Spreadsheets::class);
        $this->googleSheetServiceMock->spreadsheets = $this->sheetResourceMock;
    }


    /** @test */
    public function exports_successfully_to_spreadsheet()
    {
        $spreadsheetId = uniqid();
        $resultSheetObj = new Google_Service_Sheets_Spreadsheet();
        $resultSheetObj->spreadsheetId = $spreadsheetId;

        $this->sheetResourceMock->expects(static::once())
            ->method('create')
            ->with((array)new Google_Service_Sheets_Spreadsheet())
            ->willReturn($resultSheetObj);

        $permission = new Google_Service_Drive_Permission();
        $permission->setType('anyone');
        $permission->setRole('reader');

        $this->drivePermissionResourceMock->expects(static::once())
            ->method('create')
            ->with((array)$resultSheetObj->spreadsheetId, (array)$permission);

        $body = new Google_Service_Sheets_ValueRange(['values' => $this->dataProvider->dataExport()->getExportData()]);
        $params = ['valueInputOption' => 'USER_ENTERED'];

        $this->spreadsheetsValuesResourceMock->expects(static::once())
            ->method('update')
            ->with(
                (array)$resultSheetObj->spreadsheetId, (array)'Sheet1', (array)$body, $params
            )
            ->willReturn(new UpdateValuesResponse());

        $exportService = new GoogleClient(
            $this->googleSheetServiceMock,
            $this->driveServiceMock,
            $this->loggerMock);

        $result = $exportService->exportSheet($this->dataProvider->dataExport());

        $this->assertEquals($spreadsheetId, $result);
    }



}