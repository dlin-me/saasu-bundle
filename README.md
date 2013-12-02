Dlin Symfony Saasu Bundle
=========

Dlin Saasu Bundle is Symfony2 wrapper bundle for the [Saasu PHP Client](https://github.com/dlin-me/saasu) library. Please refer to the documentation for details usage.


This Saasu Bundle provides a configurable service to work with Saasu





Installation
--------------


Installation using [Composer](http://getcomposer.org/)

Add to your `composer.json`:


    json
    {
        "require" :  {
            "dlin/saasu-bundle": "dev-master"
        }
    }


Enable the bundle in you AppKernel.php


    public function registerBundles()
    {
        $bundles = array(
        ...
        new Dlin\Bundle\SaasuBundle\DlinSaasuBundle(),
        ...
    }


Configuration
--------------
For example:

    #app/config/config.yml

    dlin_saasu:
        wsaccesskey: D4A92597762C4FDCAF66FF03C988B7B2
        file_uid: 41555



Usage
--------------

Geting the service in a controller

    $service =  $this->get('dlin.saasu_service');

Getting the service in a ContainerAwareService

    $service = $this->container->get('dlin.saasu_service');

The service provide one method to return an instance of Dlin\Saasu\SaasuAPI, for details example please look at the [Saasu PHP Client](https://github.com/dlin-me/saasu) library

    $api = $service->getApi();

Contacting the Saasu web service API could be slow. If you do not need instant result from the service, you can delay execution of the your tasks to improve user experience.

For example, if all you want to do is to create an Invoice in Saasu and you don't need instant response ( Invoice id or any error ). You can improve user experience by delaying execution of the task:

	//get the service
    $service =  $this->get('dlin.saasu_service');

	//create an invoice object
	$invoice = new Invoice();

	//populate invoice with data
	$invoice->transactionType = 'S';
	...
	//This will create the Invoice straightaway, user will experience minor delay
	$service->getApi()->saveEntity($invoice);

	//This will postpone Invoice creation till HTTP respond is sent to user
    $service->schedule('saveEntity', $invoice);



This is most useful in creating, updating or deleting entities though all Api methods can be postponded in similar way. You can if you want, to perform a postponed/scheduled  search or load. But it is useless as the result is not reachable.

Example for scheduling an Invoice deletion follows:

    $service->schedule('deleteEntity', $invoice);



License
-

MIT

*Free Software, Yeah!*


