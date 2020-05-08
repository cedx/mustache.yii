#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

$phpdoc = $IsWindows ? 'php "C:/Program Files/PHP/share/phpDocumentor.phar"' : 'phpdoc';
Invoke-Expression "$phpdoc --config=etc/phpdoc.xml"

Copy-Item doc/img/favicon.ico doc/api
mkdocs build --config-file=etc/mkdocs.yaml
