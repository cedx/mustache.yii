#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

$version = (Get-Content composer.json | ConvertFrom-Json).version
(Get-Content etc/phpdoc.xml) -replace 'version number="\d+(\.\d+){2}"', "version number=""$version""" | Out-File etc/phpdoc.xml
