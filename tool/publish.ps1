#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

$version = (Get-Content composer.json | ConvertFrom-Json).version
git tag "v$version"
git push origin "v$version"
