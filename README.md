# Temporary SMS Number Platform

A production-ready Laravel 12 enterprise application for purchasing temporary virtual phone numbers to receive SMS verification codes.

## Project Overview

**Temp Number Platform** is a comprehensive SaaS application that allows users to:
- Purchase temporary virtual phone numbers
- Receive SMS verification codes in real-time
- Support multiple SMS providers (5SIM, SMSPool, SMS-Man, SMSActivate, GetaText)
- Manage wallet and payments
- Access comprehensive admin dashboard
- Utilize REST API for integrations

## Technology Stack

- **Framework**: Laravel 12
- **PHP**: 8.3+
- **Database**: MySQL 8+
- **Frontend**: Bootstrap 5, Blade Templates
- **Authentication**: Laravel Breeze + Sanctum
- **Authorization**: Spatie Laravel Permission
- **Real-time**: Laravel Reverb (WebSockets)
- **Caching**: Redis
- **Queue**: Laravel Queue with Supervisor
- **API Documentation**: Swagger/OpenAPI

## Key Features

### Core Functionality
- ✅ Temporary SMS Number Purchase
- ✅ Long-term Rentals (1-30 days)
- ✅ Dedicated Numbers
- ✅ Real-time SMS Reception via WebSockets
- ✅ Multiple Payment Gateways (Paystack, Flutterwave, Monnify, Bank Transfer)
- ✅ Comprehensive Wallet System

### User Features
- ✅ Email & 2FA Authentication
- ✅ User Dashboard with Statistics
- ✅ Referral Program
- ✅ Order Management
- ✅ Transaction History
- ✅ Support Tickets
- ✅ Device Login History

### Admin Features
- ✅ Advanced Dashboard Analytics
- ✅ Country Management
- ✅ Service Management
- ✅ Provider Integration & Monitoring
- ✅ User & Order Management
- ✅ Report Generation (PDF, Excel, CSV)
- ✅ Role & Permission Management
- ✅ System Settings & Configuration

### Technical Features
- ✅ Clean Architecture & SOLID Principles
- ✅ Repository & Service Patterns
- ✅ Comprehensive Security Implementation
- ✅ REST API with Rate Limiting
- ✅ Event-Driven Architecture
- ✅ Comprehensive Testing Suite
- ✅ Docker & Docker Compose Support
- ✅ CI/CD with GitHub Actions

## Module Development Order

1. Database Design (ERD + Migrations)
2. Models & Relationships
3. Seeders & Factories
4. Authentication
5. Roles & Permissions
6. Wallet System
7. Countries Module
8. Services Module
9. Provider Integration Architecture
10. Order System
11. SMS Processing
12. Payment Gateways
13. Admin Panel
14. User Dashboard
15. REST API
16. Notifications
17. Reports
18. Blog & FAQ
19. Security Hardening
20. Testing
21. Deployment (Nginx, Supervisor, Redis, Queue, Cron, SSL)
22. Docker & Docker Compose
23. CI/CD (GitHub Actions)

## Status

🚀 **Under Active Development** - Module 1: Database Design & Migrations (in progress)