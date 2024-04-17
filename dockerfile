# Use the official Nginx image
FROM nginx:latest

# Copy the entire folder into the container
COPY index.php /usr/share/nginx/html

# Expose port 80
EXPOSE 80

# Start Nginx in the foreground
CMD ["nginx", "-g", "daemon off;"]
