## About Assesment

Coding Task Summary

- API Endpoint
1. POST /api/bulk-onboard
2. Payload: list of organizations (assume up to 1000 records per request). 
3. The API should respond quickly with a batch_id and offload heavy processing to background queues

- Database Requirement
1. Create a table named organizations with sample columns such as:
- id (primary key)
- name (string)
- domain (string, unique)
- contact_email (string, nullable)
- status (pending / processing / completed / failed)
- created_at, updated_at 

You may add additional fields such as batch_id, processed_at, failed_reason, etc., if required.


- Queues / Jobs
1. Dispatch a job per newly inserted organization (e.g., ProcessOrganizationOnboarding). 
2. Jobs must be idempotent. 
3. Implement retry, backoff, and failure handling


- Bulk Insert
1. Insert records in chunks (e.g., 500–1000
2. Handle duplicates using constraints and upsert/skip strategy.


- Performance
1. Design for sustained throughput of 10 requests per second.
2. Keep the request path lightweight; heavy logic must run asynchronously.


- Testing & Observability
1. Feature test for the API endpoint.
2. Unit test for job idempotency
3. Structured logging (batch_id, organization_id, status).

- CI/CD Requirement
1. Add a CI pipeline configuration file in the repository (GitHub Actions, GitLab CI, or Bitbucket Pipelines).
2. The pipeline should run dependency installation and automated tests at minimum

- Suggestions / Improvements
1. Please include a short section in README.md describing assumptions, trade-offs, and alternative solutions or
   improvements you would suggest for a production-grade system.

- Submission

Share a Git repository link along with setup instructions, queue configuration, and test execution steps.
