FROM mysql:5.6

# Set environment variables
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=mydb
ENV MYSQL_USER=admin
ENV MYSQL_PASSWORD=pwd

# Copy SQL script (generated from your data.json)
COPY init.sql /docker-entrypoint-initdb.d/