#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

phpdoc --config=etc/phpdoc.xml
if (-not (Test-Path doc/api/images)) { New-Item doc/api/images -ItemType Directory | Out-Null }
Copy-Item doc/img/favicon.ico doc/api/images
mkdocs build --config-file=etc/mkdocs.yaml
