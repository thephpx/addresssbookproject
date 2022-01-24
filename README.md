# Overview

Requirement was to create an addressbook with CRUD options and an overview page.

# Development Roadmap

Since this is my first symfony application I set myself to learn about basic route management and twig templating. Once that is done I lookuped up how symfony managed form and how doctrine was querying the databse. While learning about doctrine, I figured out about entity and how schema was to be validated and updated. 

First thing I did was to updated the existing default controller and incorporated additional methods for create, edit, delete and view pages. Once the routes are there and linked with the controller method using annotations. I created the related view files and linked them through the controller method. 

Then, I started with creating the entity. Initially I was planning to create two entities country and address and have relationship setup between them. But then I figured symfony already has a CoutryType field, so I decided not to make to overly complicated as that my not be the objection of this job, rather to figure out if I am able to identity and use existing framework features.

Once the forms are setup and working through doctrine, I set out to figure out how to setup file uploader. Initially it was done through a simple service class. But afterwards, I figuired I can use a doctrine event observers to automate the process and reduce code from the controller. So, I incorporated an observer for prePersist, preUpdate, and postLoad events.

Now that my application was doing more of less what was required of it. I focused on the listing page. I figured there was no in-built bootstrap pagination or any sort of pagination support on symfony for doctrine. But there is a composer library called KnpPaginator which works quite well. So, I installed and implemented it on my address controllers indexAction and on the index twig template.

As all the base requriements of the projects are done I set up to port all static texts into language files. So, first I configured it to use locale and then created the messages.en.yml file to store the entire application specific texts in English.

Also, I have incorporated flash value based notification that shows up after create, update and delete event. 

Since, this is my first application in symfony, I implemented a basic smoke test initially to ensure the endpoints are working fine. Then went on the implement some functional test to check if the database is populated as expected.


# Setup

To validate the schema
> 

To update the schema
> 

To start the symfony development server
> ./bin/console server:start

To stop the symfony development server
> ./bin/console server:stop