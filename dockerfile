# Use the official Nginx image
FROM nginx:latest

# Copy all files and directories into the container
COPY . /usr/share/nginx/html

# Expose port 80
EXPOSE 80

# Start Nginx in the foreground
CMD ["nginx", "-g", "daemon off;"]
