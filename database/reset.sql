UPDATE mysql.user SET Password='' WHERE User='root';
FLUSH PRIVILEGES; 