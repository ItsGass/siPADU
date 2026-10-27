@echo off
setlocal EnableExtensions
cd /d "%~dp0"

echo ============================================
echo   SIPADU - Setup Awal
echo ============================================
echo.

set "PHP_EXE="
where php >nul 2>nul
if not errorlevel 1 (
    for /f "delims=" %%I in ('where php') do set "PHP_EXE=%%I"
)

if not defined PHP_EXE (
    for /d %%D in ("C:\laragon\bin\php\php-*") do (
        if exist "%%~fD\php.exe" set "PHP_EXE=%%~fD\php.exe"
    )
)

if not defined PHP_EXE (
    echo [ERROR] PHP tidak ditemukan.
    echo Buka Laragon, klik Terminal, lalu jalankan setup.bat dari folder ini.
    goto :gagal
)

set "COMPOSER_CMD="
where composer >nul 2>nul
if not errorlevel 1 (
    for /f "delims=" %%I in ('where composer') do set "COMPOSER_CMD=%%I"
)

if not defined COMPOSER_CMD (
    if exist "C:\laragon\bin\composer\composer.bat" (
        set "COMPOSER_CMD=C:\laragon\bin\composer\composer.bat"
    )
)

if not defined COMPOSER_CMD (
    echo [ERROR] Composer tidak ditemukan.
    echo Pastikan Laragon sudah terinstall dan Composer tersedia.
    goto :gagal
)

if /I "%~1"=="--check" (
    echo [OK] PHP      : %PHP_EXE%
    echo [OK] Composer : %COMPOSER_CMD%
    exit /b 0
)

if not exist ".env" (
    copy /Y ".env.example" ".env" >nul
    echo [OK] File .env dibuat dari .env.example.
) else (
    echo [INFO] File .env sudah ada, tidak ditimpa.
)

echo.
echo [1/4] Menginstall dependensi PHP...
call "%COMPOSER_CMD%" install --no-interaction
if errorlevel 1 goto :gagal

echo.
echo [2/4] Membuat application key...
"%PHP_EXE%" artisan key:generate --force
if errorlevel 1 goto :gagal

echo.
echo [3/4] Membuat database...
"%PHP_EXE%" scripts\create-database.php
if errorlevel 1 goto :gagal

echo.
echo [4/4] Menyiapkan tabel dan data contoh...
echo [PERINGATAN] Database sipadu akan dikosongkan dan diisi data demo.
"%PHP_EXE%" artisan migrate:fresh --seed --force
if errorlevel 1 goto :gagal

"%PHP_EXE%" artisan optimize:clear >nul 2>nul

echo.
echo ============================================
echo   SETUP SELESAI
echo ============================================
echo.
echo Jalankan aplikasi dengan: start.bat
echo.
pause
exit /b 0

:gagal
echo.
echo [GAGAL] Setup belum selesai.
echo Pastikan Laragon sudah dibuka dan MySQL sudah berjalan (Start All).
echo.
pause
exit /b 1
