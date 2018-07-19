# Messaging

Steps for setup:
1. composer install
2. Add Laravel public path to your nginx config
3. API Endpoint - 
      URL - localhost/api/send-sms<br>
      Method - POST<br>
      Body - {"mobile":"8877665544","message":"Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling."}<br>
4. Run queue - php artisan queue:work redis
5. Logs available at storage/logs/sms.log
