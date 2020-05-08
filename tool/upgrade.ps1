#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

git reset --hard
git fetch --all --prune
git pull --rebase

$composer = $IsWindows ? 'php "C:\Program Files\PHP\share\composer.phar"' : 'composer'
Invoke-Expression "$composer update --no-interaction"
