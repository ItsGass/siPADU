@echo off
setlocal EnableExtensions
cd /d "%~dp0"

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
    echo Buka Laragon, klik Terminal, lalu jalankan start.bat dari folder ini.
    pause
    exit /b 1
)

if not exist ".env" (
    echo [ERROR] File .env belum ada.
    echo Jalankan setup.bat terlebih dahulu.
    pause
    exit /b 1
)

echo ============================================
echo   SIPADU - Server Lokal
echo ============================================
echo.
echo Alamat : http://127.0.0.1:8000
echo Jangan tutup jendela ini selama memakai aplikasi.
echo Tekan Ctrl+C untuk menghentikan server.
echo.

start "" cmd /c "timeout /t 3 >nul & start http://127.0.0.1:8000"
"%PHP_EXE%" artisan serve --host=127.0.0.1 --port=8000
