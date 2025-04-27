# Laravel Project Setup Guide

This guide will walk you through the basic setup requirements for running a Laravel project.

## Installing PHP

### Windows

1. Download PHP from the official Windows downloads:

    - Choose the latest stable version (PHP 8.2 or 8.3 recommended)
    - Select the "VS16 x64 Thread Safe" zip file

2. Extract the zip file to `C:\PHP`

(yofadal to7dar video kif t3ml download lal php la2n fi shway config badak tzidon 3 min video bi5ales kel shi)

3. Check if PHP is installed correctly:

    - Open Command Prompt
    - Type: `php -v`
    - You should see the PHP version information

4. Check installation:
    ```
    php -v
    ```

## Installing Composer

### Windows

1. Download the Composer installer from: https://getcomposer.org/Composer-Setup.exe
2. Run the installer and follow the instructions
3. Check installation:
    ```
    composer --version
    ```

## Installing Laragon (Windows)

Laragon provides a complete development environment with Apache, MySQL, PHP, and more.

1. Download from: https://laragon.org/download/ (get the Full version)
2. Run the installer
3. Start Laragon from the desktop icon
4. Verify it's working by checking the system tray icon

## Running Your Laravel Project

After all components are installed, you can:

1. Navigate to your project directory
2. Start the development server:

    ```
    php artisan migrate
    ```

    ```
    php artisan db:seed
    ```

    ```
    php artisan serve
    ```

3. Access your project at: http://localhost:8000
