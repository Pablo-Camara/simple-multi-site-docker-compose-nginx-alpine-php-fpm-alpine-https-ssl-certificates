# Simple multi-site server with docker-compose/nginx:alpine/php:fpm-alpine

Quickly setup a multi site server, 
 
 - Includes example on how to add HTTPS / SSL Certificates (in my case I had used cloudflare's one), you just have to uncomment lines and edit the certificate files / add your own.
 
Your just need to git clone this, docker-compose up,and edit your hosts file (example):

YOUR_DOCKER_CONTAINER_IP    site-one.com

YOUR_DOCKER_CONTAINER_IP    site-two.com

On Production:
(Just set up your DNS normally)



Accepting any suggestions on how to make the most out of this ideia / repo.
