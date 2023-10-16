@echo off
start /min "" cmd /k "/apache24/bin/httpd.exe"
start /min cmd /k "cd C:\Users\thier\Desktop\Sonatel Academy\home stretch\backend && phpstorm && exit"
start /min "" cmd /k "cd C:\Users\thier\Desktop\Sonatel Academy\home stretch\backend && php artisan serve"
start /min "" cmd /k "cd C:\Users\thier\Desktop\Sonatel Academy\home stretch\mobile && code ."
start /min "" cmd /k "cd C:\Users\thier\Desktop && start postman && exit"
start cmd /k "cd C:\Users\thier\Desktop\Sonatel Academy\home stretch && flutter emulator --launch Pixel_4_API_33"

