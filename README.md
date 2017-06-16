# Entity Utilities
Provides simply Doctrine Entity Utilities.

## Parameter Bag
Easily construct an entity through the constructor.

```php
use GeoSocio\EntityUtils\ParameterBag;

class User {

  __construct(array $data = []) {
    $params = new ParameterBag($data);
    $this->id = $params->getInt('id');
    $this->first = $params->getString('first');
    $this->last = $params->getString('last');
    $this->address = $params->getInstance('address', Address::class, new Address());
    $this->posts = $params->getCollection('posts', Post::class, new ArrayCollection());
  }

}
```

## CreatedTrait
Include the trait in your entity to add a 'created' field that is added on
persist.
```php
use GeoSocio\EntityUtils\CreatedTrait;

class User {

  use CreatedTrait;

}
```
