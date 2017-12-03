Sorting card : Description
========================

This is a proposed solution for the Diamond, Heart, Spade, Club game card, where the user accepts 10 randomly selected cards and then sort them by category and value.

Installation
--------------
This repo conatins all the necessary vendor files, no need to launch composer update/install, to launch the app, please poceed as follows:
  * Clone the above repo inside a folder of your choice.
  * Run the php **bin/console server:run** command (for the symfony's internal server).
  * **Or** Copy the directory in your working preinstalled server.
  * Execute the following command to publish the assets required by the JsRoutingBundle :
  **php bin/console assets:install --symlink web**

How to use / test
-----------
* Access the platform's url.
* Click the **Get/Sort new cards!** button:

The server returns the 10 randomly selected cards, followed by the sort by category and values.

* Click the **Verify/send sorted cards!** button:

The proposed solution is sent to the server for validation, it returns either a success or fail message.

Used bundles
------------
* FOSJsRoutingBundle :

This bundle allows you to expose your routing in your JavaScript code

https://github.com/FriendsOfSymfony/FOSJsRoutingBundle

* JMSSerializerBundle : 

This bundle integrates the serializer library into Symfony.

https://github.com/schmittjoh/JMSSerializerBundle

