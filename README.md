# Zend Framework 2 Extensions #

Zend Framework 2 Extensions (ZfExt) is a collection of various plugins and abstract
classes designed to make your ZF2 life easier.

Parts of these extensions make use of (and rely on) Doctrine. Specifically, the
[DoctrineORMModule][].


## Installation ##
The installation of this ZF2 module requires composer. Simply run the following command:

    composer require doctrine/doctrine-orm-module

and then add the `Blake\ZfExt` module to your `config/application.config.php`.

**Note:** If you have not done so by now, it may be advantageous to follow the instructions
for installing [DoctrineORMModule][].

[DoctrineORMModule]: https://github.com/doctrine/DoctrineORMModule


## Components ##

* Abstract Classes
  * [`Module\AbstractModule`](#moduleabstractmodule)
* Controller Plugins
  * [`Controller\Plugin\Entity`](#controllerpluginentity)

### Module\AbstractModule ###
This is a base module class that other modules should extend from in order to gain some
sane default configuration options.

This module will set up the Doctrine annotation paths for you module, register an alias
with Doctrine for your module (so you can reference entities with `ModuleNamespace:Entity`),
set up view paths and allow for YAML-based routing.

### Controller\Plugin\Entity ###
An invokable controller plugin that will grab the entity manger or, if an entity name is
provided, get the entity repository.

**Example:**

    $repo = $this->entity('App:Album');

## In Closing... ##
Do note that these extensions are (probably) quite opinionated as they've largly grown out
of my personal use, so I won't bend over backwards to make these extensions work on more
general cases.

That being said, anyone is welcome to fork and make pull requests if he or she has suggestions,
criticisms, improvements, et al.
