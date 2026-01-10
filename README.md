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


---

## Assesment setup instructions:

---
### Project Setup Note:
    a) This setup project will only work on Linux & Mac. 
    b) Before running this configuration make sure you stop/uninstall the apache/nginx, mysql, redis in your system.
    c) You need sudo access for setup the proects.
    d) If you using Mac, you need to install docker, docker-composer manually.


---
### System Configuration
    1. Clone this repository
    2. Go to Root directory using your terminal.
    3. Type `sh init.sh` in your terminal and press enter.
    4. Now Type `source ~/.bash_profile` in your terminal and press enter.
    5. Done!

---

## Please Add Project name (As per repo) in projects.txt file, Before start ```dev setup```.  Path of projects.txt file is:- bash/projects.txt
---
### Project Setup
- Run ``` dev setup``` and press entry. Now please follow the instruction in terminal.
    - This command will -
        1. Update the /etc/hosts
        2. Install the GIT and Mysql-client
        3. Create docker network.
        4. pull the git repository.
        5. checkout to master branch
        6. create .env file from .env.example
        7. set the folder permission

- Once setup is done. Fix you .env file in following ways -
    1. Verify all the env keys, there should not be any extra space.
    2. Update the database keys.
       OR

### Mysql DB:-
```bash
    DB_HOST=db
    DB_DATABASE=*
    DB_USERNAME=database_api
    DB_PASSWORD=DDwgLAA3WH2a2k1h
 
    mysql -u root -p 1fN82Avd7TT5Bad2 database_api -h 127.0.0.1 -P 3309
```

---
### Virtual Hosts
Below are the list of hosts that you can use:

- [Assesment API](http://api.assesment.local) => ```http://api.assesment.local```.

---
### Command Line Manager [BFRS]
Here are some list of command that you can use:

#### Command For Container Start, Stop, Restart, Clean and Debug.

- **Setup (``` dev setup```)**: This command will do all the required setup seeded in your system.
- **Start (``` dev start```)**: This command will start all the containers.
- **Stop (``` dev stop```)**: This command will stop all the containers.
- **Restart (``` dev restart```)**: This command will restart all the containers.


#### Command For Backend

- **Composer (``` bfrs composer```)**: This command will run the composer install in your container.

---
### Testing Instructions
- To run the tests, use the following command:
  - ``` dev test ```

### curl for API testing

```bash
curl --location 'http://api.assesment.local:85/api/bulk-onboard' \
--header 'Content-Type:  application/json' \
--header 'Accept:  application/json' \
--data-raw '[
    {
        "name": "ABC6",
        "domain": "abcd.com",
        "contact_email": "test@abc6.com"
    }
]'

```

### Suggestions / Improvements
1. For a scalable heavy load system, I would consider using a more robust message queue system like RabbitMQ or Apache Kafka instead of relying solely on Laravel's built-in queue system. This would allow for better handling of high throughput and complex message routing.