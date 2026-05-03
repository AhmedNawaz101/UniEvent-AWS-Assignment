#!/bin/bash

# Update system
sudo yum update -y

# Install Apache + PHP
sudo yum install -y httpd php

# Start and enable Apache
sudo systemctl start httpd
sudo systemctl enable httpd

# Set permissions
sudo usermod -a -G apache ec2-user
sudo chown -R ec2-user:apache /var/www
sudo chmod 2775 /var/www

# Create web root file placeholder
sudo touch /var/www/html/events.php
sudo chown ec2-user:apache /var/www/html/events.php

echo "Server setup completed successfully"