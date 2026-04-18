# Put WinGet PHP 8.3 first on PATH for this process, then run Composer.
# Usage (from this folder):  powershell -ExecutionPolicy Bypass -File .\Composer-WithPHP83.ps1 install
# Or:                         .\Composer-WithPHP83.ps1 update

$ErrorActionPreference = "Stop"

$pkgRoot = Join-Path $env:LOCALAPPDATA "Microsoft\WinGet\Packages"
$phpDir = Get-ChildItem -Path $pkgRoot -Directory -ErrorAction SilentlyContinue |
    Where-Object { $_.Name -like "PHP.PHP.8.3*" } |
    Select-Object -ExpandProperty FullName -First 1

if (-not $phpDir) {
    Write-Host "Could not find WinGet PHP 8.3 under:" $pkgRoot
    Write-Host "Install it: winget install PHP.PHP.8.3 --accept-package-agreements"
    exit 1
}

$phpExe = Join-Path $phpDir "php.exe"
if (-not (Test-Path $phpExe)) {
    Write-Host "php.exe not found in:" $phpDir
    exit 1
}

# WinGet PHP must come before XAMPP / other old PHP entries
$env:Path = "$phpDir;" + $env:Path

Write-Host "PHP in use:" -ForegroundColor Cyan
& $phpExe -v
Write-Host ""

$hasSsl = & $phpExe -r "echo extension_loaded('openssl') ? '1' : '0';"
if ($hasSsl -ne "1") {
    Write-Host "OpenSSL extension is OFF. Composer needs it for HTTPS." -ForegroundColor Yellow
    Write-Host "Run once:" -ForegroundColor Yellow
    Write-Host "  powershell -ExecutionPolicy Bypass -File .\Enable-PhpOpenSSL.ps1" -ForegroundColor White
    Write-Host "Then re-run this script." -ForegroundColor Yellow
    exit 1
}

$composer = Get-Command composer -ErrorAction SilentlyContinue
if (-not $composer) {
    Write-Host "composer not found on PATH. Install Composer from https://getcomposer.org/download/"
    exit 1
}

& composer @args
exit $LASTEXITCODE
