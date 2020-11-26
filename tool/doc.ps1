#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

phpdoc --config=etc/phpdoc.xml
if (-not (Test-Path docs/api/images)) { New-Item docs/api/images -ItemType Directory | Out-Null }
Copy-Item docs/favicon.ico docs/api/images
