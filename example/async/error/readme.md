# Error state

Simplified demonstration of error state handling to get the idea of
what the package is capable of.

Main take here is to add an error widget to spinner in case of error.

```php
$error->add($errorMessage->getContext());
$spinner->add($error->getContext());
```
