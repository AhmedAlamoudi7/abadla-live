# One-time: enable PostgreSQL PDO for WinGet PHP 8.3 (Laravel DB_CONNECTION=pgsql).
# Run from cms:  powershell -ExecutionPolicy Bypass -File .\Enable-PhpPgsql.ps1

$ErrorActionPreference = "Stop"

$pkgRoot = Join-Path $env:LOCALAPPDATA "Microsoft\WinGet\Packages"
$phpDir = Get-ChildItem -Path $pkgRoot -Directory -ErrorAction SilentlyContinue |
    Where-Object { $_.Name -like "PHP.PHP.8.3*" } |
    Select-Object -ExpandProperty FullName -First 1

if (-not $phpDir) {
    Write-Error "WinGet PHP 8.3 folder not found under $pkgRoot — adjust the pattern in this script or set `$phpDir` to your php.exe folder."
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

$content = $content -replace '(?m)^\s*;\s*extension_dir\s*=\s*"ext"\s*$', 'extension_dir = "ext"'
$content = $content -replace '(?m)^\s*;\s*extension_dir\s*=\s*"\s*ext\s*"\s*$', 'extension_dir = "ext"'

# PDO PostgreSQL (uncomment)
$content = $content -replace '(?m)^\s*;\s*extension\s*=\s*pdo_pgsql\s*$', 'extension=pdo_pgsql'
$content = $content -replace '(?m)^\s*;\s*extension\s*=\s*pgsql\s*$', 'extension=pgsql'

Set-Content -Path $ini -Value $content -Encoding utf8

Write-Host "Updated:" $ini -ForegroundColor Cyan
& $phpExe -r "echo extension_loaded('pdo_pgsql') ? 'pdo_pgsql: OK' . PHP_EOL : 'pdo_pgsql: STILL OFF — edit php.ini manually' . PHP_EOL;"
