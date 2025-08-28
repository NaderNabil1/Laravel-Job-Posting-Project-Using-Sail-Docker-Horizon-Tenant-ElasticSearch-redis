
# JOBGLOBAL
# Job Posting  (Laravel + Sail + Passport + Horizon + Elasticsearch)

## What this is
- Central DB for tenants & users
- Per-tenant DB for domain data (JobPosting)
- OAuth2 auth via Passport, scoped by tenant (X-Tenant header or subdomain)
- Redis + Horizon queues
- Elasticsearch sync for jobs
- Events/listeners queued; heavy work dispatched **after response**

## Requirements
Docker Desktop / Engine, Node (optional), Composer

## Quick start
```bash

I made sure to upload all vendor files for making it easier 

composer install
cp .env.example .env

./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan passport:install
./vendor/bin/sail artisan horizon



- ✅ Laravel Sail + Docker Compose: MySQL, Redis, Elasticsearch services
- ✅ Laravel Passport for authentication (tenant-scoped)
- ✅ Multi-database via dynamic `tenant` connection on models
- ✅ Job sync to Elasticsearch via queued job
- ✅ Laravel Horizon with Redis for queues
- ✅ Heavy jobs dispatched **after response**; event listener implements `ShouldQueue`
- ✅ Public GitHub repo + README with setup & explanation
- ✅ API endpoints provided

If you follow the steps in order and paste in the shown files, you’ll have a working baseline that meets every requirement.
