FROM nginxinc/nginx-unprivileged:1.29-alpine
COPY nginx.conf /etc/nginx/nginx.conf
COPY conf.d/ /etc/nginx/conf.d/
COPY snippets/ /etc/nginx/snippets/
# Configuration is immutable at runtime; no entrypoint rewrite is necessary.
ENTRYPOINT ["nginx"]
CMD ["-g", "daemon off;"]
EXPOSE 8080 8443
