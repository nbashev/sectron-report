## SECTRON Reports SERVER

Reports server for working tasks build in Laravel and hosted on Windows Server 2012 - IIS8

## Installation Steps

* Install Role Web Server (adding .NET 3.5 feature)
* Install Web Platform installer
* Using Platform installer get PHP version 5.6.16, Php Manager
* Install Composer and Git
* clone git@github.com:hew86i/sectron-report.git
* Add permitions to IIS_USERS (or Everyone) on root folder (storage, vendor, bootstrap)
* edit php.ini file (sys_temp_dir = 'path/to/my/dir')
* edit php.ini file (enable error reporting)
* Add permitions on that tmp folder (used when generating pdf)


#### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Sectron Report web-app is internaly used software

_sectron-report_
