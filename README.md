# UniEvent - AWS Cloud Architecture
## CE 308/408 Cloud Computing | Assignment 1
### GIK Institute of Engineering Sciences and Technology

**Student ID:** 2023085 
**Role:** Cloud Architect

---

## Project Overview
UniEvent is a scalable university event management system deployed on AWS.
It automatically fetches real-time event data from the Ticketmaster API
and displays it to students through a fault-tolerant web application.

---

## AWS Services Used
- **IAM** - EC2 role for secure S3 access (no hardcoded credentials)
- **VPC** - Isolated network with public/private subnets across 2 AZs
- **EC2** - Two app servers in private subnets (fault tolerant)
- **S3** - Stores event JSON data and student poster uploads
- **ELB** - Application Load Balancer distributing traffic across both servers

---

## Architecture
