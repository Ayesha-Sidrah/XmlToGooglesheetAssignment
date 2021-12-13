# XmlToGooglesheetAssignment

## About

This is a command line application based on Symfony. It processes a local or remote xml file's data to a Google Spreadsheet with Google Sheets API.

## Technologies Used

* PHP 7.4
* Symfony 5.3

## Setup

Create Google service account and download JSON file which consists of all the credentials.

Enable Google Sheets API and Google Drive API.

Next step is to setup environment. file.env contains all the variables required for application.

For Google service account set following env variable. Write path to the credentials JSON file.

```
GS_AUTH_FILE= Cred.json
```
For accessing files from remote server set following env credentials
```
FTP_HOSTNAME=
FTP_USER=
FTP_PASSWORD=
```
## Export Command

For local export run this command inside the php container
```
bin/console app:upload-command --source local abc.xml
```

For remote export run this command inside the php container
```
bin/console app:upload-command --source remote employee.xml
```

## Run tests

Run following inside the container
```
./vendor/bin/phpunit tests/
```

## Logs

Logs for the application are stored in the 'environment'.log file. In dev environment dev.log file.
