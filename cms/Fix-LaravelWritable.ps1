# Clears read-only on folders Laravel must write to (common under OneDrive / copied zips).
# Run from cms:  powershell -ExecutionPolicy Bypass -File .\Fix-LaravelWritable.ps1

$ErrorActionPreference = "Stop"
$root = $PSScriptRoot

$paths = @(
    Join-Path $root "bootstrap\cache"
    Join-Path $root "storage"
    Join-Path $root "storage\app"
    Join-Path $root "storage\app\public"
    Join-Path $root "storage\framework"
    Join-Path $root "storage\framework\cache"
    Join-Path $root "storage\framework\cache\data"
    Join-Path $root "storage\framework\sessions"
    Join-Path $root "storage\framework\views"
    Join-Path $root "storage\logs"
)

foreach ($p in $paths) {
    if (Test-Path $p) {
        attrib -r "$p\*.*" /s /d 2>$null | Out-Null
        attrib -r "$p" /s /d 2>$null | Out-Null
        Write-Host "OK:" $p
    }
}

Write-Host "`nDone. Run: php artisan package:discover" -ForegroundColor Cyan
