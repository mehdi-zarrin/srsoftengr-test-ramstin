#  iMoney Senior Software Enginner Test

## Instructions

We expect you to be familiar with [git][1], [Vagrant][2] and [VirtualBox][3].

The question and initial code is provided to you on this git repository.  
The provisioning facility of vagrant will give you a box with the necessary software to get you started.  
Your solution should be committed back into this repository like you would do in a normal project.  
You can commit and push as many times as you want.

Please make sure you update the provisioner in case your solution requires extra packages, database
schema changes, code/dependencies initialization or service startup.

Your response will be pre-evaluated by an automated system by doing:

* `git clone <this repository url>`
* `vagrant up --provision`
* run checks against index.php, stats.php and database.

Ensure those steps work as you would expect before asking for your answer to be evaluated.

## Intro and background info

We have a very busy lead collection system that receives leads from our customers 24/7.
Our customers visit our websites/mobile apps and leave their details to be contacted by our Call Operators.
Daily we receive and process numerous leads which is handled by our lead collections system.

All of this is done by the code that is provided to you in this test.

An example of a call to our lead collection API could look like this:

http://localhost/index.php?name=mrbean&mobno=0123456789&email=mrbean@example.com

## Goal 1

The first goal is to transform this smelly code into production grade, quality code that follows
modern software development practices. We can't emphasize enough the importance of this! We use Silex a lot FYI!

You will also notice that this code doesn't perform well. The `token` is inherently slow and you may
assume there is absolutely nothing you can do to improve the `token` command.

Can you improve the design in such a way that it can handle tens of thousands of requests per second? 

Hints: You can introduce queuing.

## Goal 2

Configure a NodeJS application that communicates with the lead collector to find out the next 100 items in queue to be processed and show them in a list with AngularJS pagination.

## Bonus
There is also a stats.php file that is called periodically by our monitoring system to provide it with
relevant performance statistics of our Lead Collection API.

The problem here is that it is very slow, something which seriously impacts the monitoring system.

Your goal is to solve this problem and make sure that stats.php takes less than one second to run.


## How to check performance

A simple way of checking the performance of the Lead Collection API is to use Apache's ab tool, like this:

`ab -n 1000 -c 10 "http://localhost/index.php?name=mrbean&mobno=0123456789&email=mrbean@example.com"`


# FAQ

* What's this binary `token` doing?

Don't worry about this. This is a *placeholder* for external process and API calls we have no control over.

To rephrase what was stated in Goal 1, you are not allowed to change this binary in any way. Do not
spend your time on it.

  [1]: http://git-scm.com/
  [2]: https://www.vagrantup.com/
  [3]: https://www.virtualbox.org/