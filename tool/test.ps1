#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)
vendor/bin/phpunit --configuration=etc/phpunit.xml
