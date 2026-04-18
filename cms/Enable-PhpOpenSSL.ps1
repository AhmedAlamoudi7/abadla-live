# One-time: enable OpenSSL for WinGet PHP 8.3 (Composer needs it).
# Run from cms:  powershell -ExecutionPolicy Bypass -File .\Enable-PhpOpenSSL.ps1

$ErrorActionPreference = "Stop"

$pkgRoot = Join-Path $env:LOCALAPPDATA "Microsoft\WinGet\Packages"
$phpDir = Get-ChildItem -Path $pkgRoot -Directory -ErrorAction SilentlyContinue |
    Where-Object { $_.Name -like "PHP.PHP.8.3*" } |
    Select-Object -ExpandProperty FullName -First 1

if (-not $phpDir) {
    Write-Error "WinGet PHP 8.3 folder not found under $pkgRoot"
}

$phpExe = Join-Path $phpDir "php.exe"
$ini = Join-Path $phpDir "php.ini"
$dev = Join-Path $phpDir "php.ini-development"

if (-not (Test-Path $ini)) {
    if (-not (Test-Path $dev)) {
        Write-Error "Neither php.ini nor php.ini-development found in $phpDir"
    }
    Copy-Item $dev $ini
    Write-Host "Created php.ini from php.ini-development" -ForegroundColor Green
}

$content = Get-Content -Path $ini -Raw

# extension_dir (relative to PHP folder)
$content = $content -replace '(?m)^\s*;\s*extension_dir\s*=\s*"ext"\s*$', 'extension_dir = "ext"'
$content = $content -replace '(?m)^\s*;\s*extension_dir\s*=\s*"\s*ext\s*"\s*$', 'extension_dir = "ext"'

# enable openssl
$content = $content -replace '(?m)^\s*;\s*extension\s*=\s*openssl\s*$', 'extension=openssl'

Set-Content -Path $ini -Value $content -Encoding utf8

Write-Host "Updated:" $ini -ForegroundColor Cyan
& $phpExe -r "echo extension_loaded('openssl') ? 'openssl: OK' . PHP_EOL : 'openssl: STILL OFF — edit php.ini manually' . PHP_EOL;"
