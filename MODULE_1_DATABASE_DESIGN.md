# MODULE 1: Database Design (ERD + Migrations)

## Architecture Overview

This module establishes the complete database structure for the Temporary SMS Number Platform. The design follows:

- **Normalization**: 3NF to minimize redundancy
- **Foreign Keys**: Enforced at database level
- **Indexing**: Optimized for query performance
- **Soft Deletes**: Audit trail for sensitive operations
- **Timestamps**: Automatic tracking of creation/modification
- **Scalability**: Designed for millions of orders and transactions

## Entity Relationship Diagram (ERD)

### Core Entities

```
USERS
├── WALLETS (1:1)
├── WALLET_TRANSACTIONS (1:N)
├── ORDERS (1:N)
├── REFERRALS (1:N)
├── SUPPORT_TICKETS (1:N)
├── LOGIN_DEVICES (1:N)
├── LOGIN_ACTIVITIES (1:N)
└── PERSONAL_ACCESS_TOKENS (1:N)

COUNTRIES
├── SERVICES (1:N)
└── PROVIDERS_COUNTRIES (N:N via pivot)

SERVICES
├── ORDERS (1:N)
├── PROVIDER_SERVICES (1:N)
└── COUNTRIES (N:1)

PROVIDERS
├── PROVIDER_SERVICES (1:N)
├── PROVIDER_COUNTRIES (1:N)
├── ORDERS (1:N)
└── PROVIDER_ACCOUNTS (1:N)

ORDERS
├── ORDER_SMS (1:N)
├── PAYMENTS (1:N)
├── REFUNDS (1:N)
├── USERS (N:1)
├── SERVICES (N:1)
├── COUNTRIES (N:1)
└── PROVIDERS (N:1)

PAYMENTS
├── TRANSACTIONS (1:1)
├── WALLET_TRANSACTIONS (1:1)
└── PAYMENT_METHODS (1:N)

COUPONS
├── COUPON_USAGES (1:N)
└── ORDERS (1:N via COUPON_USAGES)

BLOGS
├── BLOG_CATEGORIES (N:1)
├── BLOG_TAGS (N:N via pivot)
└── BLOG_COMMENTS (1:N)

FAQS
└── FAQ_CATEGORIES (N:1)

SUPPORT_TICKETS
├── SUPPORT_REPLIES (1:N)
├── USERS (N:1)
└── ATTACHMENTS (1:N)

ROLES & PERMISSIONS
├── ROLE_PERMISSIONS (N:N)
├── USER_ROLES (N:N)
└── MODEL_PERMISSIONS (N:N)

SETTINGS
├── GENERAL (key-value store)
├── PAYMENT_GATEWAYS
├── EMAIL_CONFIGURATION
├── SMS_CONFIGURATION
└── SECURITY_SETTINGS
```

## Table Specifications

### 1. users
- **Purpose**: User account management
- **Key Features**: 2FA, email verification, avatar upload, device tracking
- **Indexes**: email (unique), phone (unique), username (unique), status

### 2. wallets
- **Purpose**: User financial account
- **Key Features**: Balance tracking, freeze status
- **Relationship**: One-to-One with users

### 3. wallet_transactions
- **Purpose**: Financial transaction audit trail
- **Key Features**: Type (deposit/withdrawal/credit/debit), status tracking
- **Indexes**: user_id, status, created_at

### 4. countries
- **Purpose**: Supported countries for SMS numbers
- **Key Features**: ISO codes, flags, currency
- **Indexes**: iso_code (unique), status

### 5. services
- **Purpose**: Online services requiring SMS verification
- **Key Features**: Logo, category, pricing, stock tracking
- **Indexes**: country_id, status, name

### 6. providers
- **Purpose**: Third-party SMS providers
- **Key Features**: API credentials, health monitoring, profit margins
- **Indexes**: status, priority

### 7. provider_services
- **Purpose**: Service availability per provider
- **Key Features**: Cost price, profit margin, priority
- **Relationship**: Many-to-Many (services to providers)

### 8. provider_accounts
- **Purpose**: Provider account tracking
- **Key Features**: Balance, last sync, health status
- **Indexes**: provider_id, status

### 9. orders
- **Purpose**: SMS number purchase orders
- **Key Features**: Order lifecycle (pending -> completed -> expired)
- **Indexes**: user_id, status, provider_id, created_at, expires_at
- **Soft Deletes**: Yes

### 10. order_sms
- **Purpose**: SMS messages received on rented numbers
- **Key Features**: Real-time SMS tracking
- **Indexes**: order_id, created_at

### 11. payments
- **Purpose**: Payment transaction records
- **Key Features**: Gateway tracking, payment methods
- **Indexes**: user_id, status, created_at

### 12. payment_methods
- **Purpose**: Payment method configuration
- **Key Features**: Multiple gateways (Paystack, Flutterwave, etc.)
- **Indexes**: type, status

### 13. transactions
- **Purpose**: Financial transaction ledger
- **Key Features**: Debit/Credit tracking, references to payments
- **Indexes**: user_id, type, created_at

### 14. notifications
- **Purpose**: User notification tracking
- **Key Features**: Multi-channel (email, database, SMS, browser)
- **Indexes**: user_id, read_at, created_at

### 15. support_tickets
- **Purpose**: Customer support system
- **Key Features**: Status tracking, priority levels
- **Indexes**: user_id, status, priority
- **Soft Deletes**: Yes

### 16. support_replies
- **Purpose**: Ticket conversation history
- **Key Features**: Admin/User replies with attachments
- **Indexes**: ticket_id, created_at

### 17. blogs
- **Purpose**: Blog content management
- **Key Features**: SEO-friendly, featured images, publishing
- **Indexes**: slug (unique), status, category_id
- **Soft Deletes**: Yes

### 18. blog_categories
- **Purpose**: Blog categorization
- **Indexes**: slug (unique), status

### 19. blog_tags
- **Purpose**: Blog tagging system
- **Relationship**: Many-to-Many with blogs

### 20. blog_comments
- **Purpose**: Blog comment moderation
- **Key Features**: Approval status
- **Indexes**: blog_id, status

### 21. faqs
- **Purpose**: Frequently asked questions
- **Key Features**: Categorized, searchable
- **Indexes**: category_id, status

### 22. faq_categories
- **Purpose**: FAQ categorization
- **Indexes**: status

### 23. coupons
- **Purpose**: Discount code management
- **Key Features**: Percentage/Fixed discounts, expiry, usage limits
- **Indexes**: code (unique), status, expires_at

### 24. coupon_usages
- **Purpose**: Coupon application tracking
- **Relationship**: Many-to-Many (users to coupons)

### 25. referrals
- **Purpose**: Referral program tracking
- **Key Features**: Commission tracking, status
- **Indexes**: referrer_id, referred_id, status

### 26. roles
- **Purpose**: Authorization roles
- **Indexes**: name (unique)

### 27. permissions
- **Purpose**: Authorization permissions
- **Indexes**: name (unique)

### 28. role_permissions
- **Purpose**: Role-Permission relationship
- **Relationship**: Many-to-Many

### 29. user_roles
- **Purpose**: User-Role assignment
- **Relationship**: Many-to-Many

### 30. settings
- **Purpose**: Application configuration
- **Key Features**: Key-value pairs for easy access
- **Indexes**: key (unique)

### 31. activity_logs
- **Purpose**: Audit trail for sensitive operations
- **Key Features**: User actions, IP addresses, timestamps
- **Indexes**: user_id, action, created_at

### 32. failed_jobs
- **Purpose**: Failed queue job tracking
- **Laravel Standard**: Yes

### 33. jobs
- **Purpose**: Queued job tracking
- **Laravel Standard**: Yes

### 34. sessions
- **Purpose**: Session management
- **Laravel Standard**: Yes

### 35. personal_access_tokens
- **Purpose**: API token authentication
- **Laravel Standard**: Yes
- **Indexes**: tokenable_type, tokenable_id

### 36. login_devices
- **Purpose**: Device fingerprinting for login history
- **Key Features**: Device type, browser, IP tracking
- **Indexes**: user_id, created_at

### 37. login_activities
- **Purpose**: Login attempt tracking
- **Key Features**: Success/Failure tracking, IP logging
- **Indexes**: user_id, created_at, success

## Naming Conventions

- **Tables**: `snake_case` (plural)
- **Columns**: `snake_case` (singular)
- **Foreign Keys**: `{table_singular}_id` (e.g., `user_id`, `provider_id`)
- **Pivot Tables**: `{table1_singular}_{table2_singular}` (alphabetical)
- **Timestamps**: `created_at`, `updated_at`
- **Soft Deletes**: `deleted_at`
- **Booleans**: `is_{property}` or `has_{property}`
- **Amounts**: Use `decimal(15, 2)` for financial data

## Indexing Strategy

### Primary Indexes
- All `id` columns (primary key)
- Foreign key columns
- Timestamp columns (`created_at`, `updated_at`)

### Secondary Indexes
- Status columns (filtering, sorting)
- User identifiers (email, username, phone)
- Financial columns (user_id + created_at for reports)
- Frequently queried combinations

### Unique Indexes
- `users.email`
- `users.username`
- `users.phone`
- `countries.iso_code`
- `roles.name`
- `permissions.name`
- `coupons.code`
- `blogs.slug`
- `blog_categories.slug`

## Next Steps

✅ **Module 1 Complete**: Database design and naming conventions established

⏳ **Module 2**: Generate migrations and model relationships

---

**Status**: Ready for migration generation
**Last Updated**: 2026-07-25