1. git clone
   
2. cd %project% && composer update  

3. make .env in root directory of the project  

4. php artisan key:generate

===

At now the project located - http://abebot.tk/, docs - http://abebot.tk/docs/

===

For every any request you need to set header 'Accept' with value - 'application/json'

For every request to /api/vk/* you need to set header *vk-access-token* with value of a gotten token

For every request to /api/instagram you need to set headers 'instagram-username' and 'instagram-username' with respectevely data 

