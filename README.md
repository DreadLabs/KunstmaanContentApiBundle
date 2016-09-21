# Kunstmaan Content API

## What does it do?

This bundle configures a Kunstmaan CMS instance in order to easily provide your content through
a custom API format.

It uses `willdurand/negotation` in order to inject a `Request` attribute `media_type` which is
used to delegate to a serialization of a `Page` entity (`Node`) into a specific response format.

## Installation

    composer install dreadlabs/kunstmaan-content-api-bundle

## How to use?

  1. Load the bundle in your `AppKernel`
  
         // snip
         new DreadLabs\KunstmaanContentApiBundle\DreadLabsKunstmaanContentApiBundle()
         // snap

  2. Implement the `Kunstmaan\NodeBundle\Controller\SlugActionInterface` in your `Page` entities,
     implement the `getControllerAction` and point to the Bundle's `ApiController`:
  
         // src/Acme/WebsiteBundle/Entity/Pages/HomePage.php
         <?php
         class HomePage implements [...], SlugActionInterface
         {
             // snip
             
             /**
              * @return string
              *
              */
             public function getControllerAction()
             {
                 return 'dreadlabs_kunstmaan_content_api.controller:getAction';
             }
             
             // snap
         }
     
     **Important**: Make sure, you are using the *[Controllers as Service][symfony_controller_service]* notation.
  
  3. Implement the Bundle's `DreadLabs\KunstmaanContentApiBundle\Api\SerializableInterface` in order to point the 
     Kunstmaan `Node` entity to the API representation:
     
         // src/Acme/WebsiteBundle/Entity/Pages/HomePage.php
         <?php
         use Acme\WebsiteBundle\Api\Page\Home as ApiType;
         
         class HomePage implements [...], SerializableInterface
         {
             // snip
             
             /**
              * Returns the name of the API type (class).
              *
              * @return string
              */
             public function getApiType()
             {
                 return ApiType::class;
             }
             
             // snap
         }
         
  4. Implement an API type for serialization:
  
         // src/Acme/WebsiteBundle/Api/Page/Home.php
         <?php
         class Home
         {
             /**
              * @var string
              */
             public $title;
             
             public function __construct($title)
             {
                $this->title = $title;
             }
         }
         
     Read the [Serializer documentation][serializer_doc] and the [Serializer cookbook][serializer_cookbook]
     to learn more about serialization of your API types.

## TODO

  - add configuration possibility for the `priorities` argument of `DreadLabs\KunstmaanContentApiBundle\EventListener\MediaTypeListener`
  - add configuration of expected `mediaType` in `DreadLabs\KunstmaanContentApiBundle\Api\Factory`
  - add possibility to branch between `prod` and `dev` environments in `DreadLabs/KunstmaanContentApiBundle/DependencyInjection/DreadLabsKunstmaanContentApiExtension`
  - add possibility to override / configure `framework.serializer.cache` setting in `DreadLabs/KunstmaanContentApiBundle/DependencyInjection/DreadLabsKunstmaanContentApiExtension`
    - Q: isn't that already possible by just set / unset the configuration keys in `app/config/config.yml`?

[symfony_controller_service]: http://symfony.com/doc/current/controller/service.html
[serializer_doc]: http://symfony.com/doc/current/components/serializer.html
[serializer_cookbook]: http://symfony.com/doc/current/serializer.html
