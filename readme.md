#    

This is the new repository of     projects that was created in Laravel Framework

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Project Requirements

```
Please install phpcs on your preferred development tool just make sure it follows the PSR standard.
```

### Prerequisites

What things you need to install the software and how to install them

```
composer
PHP7+
MySQL
```

### Installing

A step by step series of on how to get a development env running

Clone the project
```
git clone https://gitlab.com/   -team/new-   .git
```

Go to your directory
```
cd new-    (your project directory name)
```

Run the composer to install dependency
```
composer install
```

Update your .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD
```

Import the database file to your MySQL
```
https://drive.google.com/file/d/14jqFNkMUSoyYh-89Qd3_DclK2RKz34NA/view?usp=sharing
```

Run the migration file
```
php artisan migrate
```

Seed dummy data
```
php artisan db:seed
```

Manually install git hooks (optional)
```
cd node_modules/husky/ && node husky install
```

## Running the tests
Please refer to this [Laravel Testing](https://laravel.com/docs/5.7/testing) for documentation.

Run this command to run the test. 
```
vendor/bin/phpunit
```

## Deployment

Deployment is done via a CI/CD pipeline, facilitated by Bitbucket Pipelines. The config for this can be found in [bitbucket-pipelines.yml](bitbucket-pipelines.yml).

*Note: this applies to the [    Bitbucket repository](https://bitbucket.org/innovationcapital/   )*

### Deploy to testing/staging

*Staging is located at [staging.   .co](https://staging.   .co)*

 1. Ensure the `develop` branch is up to date. 
 2. Merge the `develop` branch into the `staging` branch.
 3. Wait for the Bitbucket Pipelines build steps to complete.
 4. Click into the deployment (via "Pipelines" in the repository menu in Bitbucket), and when it becomes available press "Deploy"

### Deploy to production

 1. Ensure the `develop` branch is up to date. 
 2. Merge the `develop` branch into the `master` branch. This could be done via a pull-request or by merging the branch straight in.
 3. Tag the merge as "release-VERSION_NUMBER" where VERSION_NUMBER should be higher than the last version number, ideally following semantic versioning.
 4. Wait for the Bitbucket Pipelines build steps to complete.
 5. Click into the deployment (via "Pipelines" in the repository menu in Bitbucket), and when it becomes available press "Deploy"

## Built With

* [Laravel](https://laravel.com/) - The web framework used
* [VueJs](https://vuejs.org/) - The templating assets
* [Composer](https://getcomposer.org/) - The PHP files dependency management
* [NodeJs](https://nodejs.org/en/) - The templating assets dependency management
* [Lodash](https://lodash.com/) - The javascript utility library for handling arrays, collections, object
* [andersao/l5-repository](https://github.com/andersao/l5-repository) - The repository that is implemented in this project
* [husky](https://github.com/typicode/husky) - For git hooks 
* [lint-staged](https://github.com/okonet/lint-staged) - Runs linter
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) - script that tokenizes PHP, JavaScript and CSS files to detect violations of a defined coding standard
* ['Eloquent-Sluggable](https://github.com/cviebrock/eloquent-sluggable#configuration) - creation of slugs for SEO friendly url
* [Bitbucket Pipelines](https://confluence.atlassian.com/bitbucket/build-test-and-deploy-with-pipelines-792496469.html) - For CI/CD deployment onto AWS
* [AWS Elastic Beanstalk](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/Welcome.html) - For load balancing, auto-scaling, monitoring, and secure environments.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Extra installation
  
Please run the following  
* Composer install  
* npm install  
* gulp  
* npm run dev  
* php artisan jwt:secret  

## Development

To clone project for development:  
1. 'Fork' repository from https://gitlab.com/   -team/new-   .git  
2. From the fork repository run 'git fetch origin'  
3. Run 'git checkout -b develop origin/develop'  
4. From the develop branch create your branch per feature (ex. git checkout -b feature/pmk-51) 

Setup local git to push codes on project 
1. Add your fork on remote list (ex. git remote add fork https://gitlab.com/mpalencia/new-   .git)  
2. Replace your git origin with the main repo source (ex. git remote set-url origin https://gitlab.com/   -team/new-   .git)  
3. Check remote list (git remote -v) see sample: http://prntscr.com/m4pajg  

To Push project 
1. Commit codes (git commit -a)
2. Git push fork develop 
   Git push origin develop

Setup GULP
1. npm install gulp
2. npm install laravel-elixir --save-dev
* Run 'gulp --production' to minify script instead of 'gulp' command


