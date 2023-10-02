@echo off
start /min "" cmd /k "/apache24/bin/httpd.exe"
start /min cmd /k "cd C:\Users\thier\Desktop\Sonatel Academy\home stretch\backend && code . && exit"
start /min cmd /k "cd C:\Users\thier\Desktop\Sonatel Academy\home stretch\frontend && ng serve --open"
start /min "" cmd /k "C:\Users\thier\Desktop\Sonatel Academy\home stretch\backend && php artisan serve"
start /min "" cmd /k "cd C:\Users\thier\Desktop\Sonatel Academy\home stretch\frontend && code . && exit"
start /min "" cmd /k "cd C:\Users\thier\Desktop && start postman && exit"
start cmd /k "cd C:\Users\thier\Desktop\Sonatel Academy\home stretch\backend"

