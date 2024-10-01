# Flatten Categories Function

## Overview

This PHP script contains a function called `flattenCategories` that takes a nested array of categories
and subcategories and flattens it into a single array containing only the category names.
The purpose of this function is to convert complex, multi-level category structures into a simple, one-dimensional list.

## Input

The input to the function is a nested associative array where each key represents a category, and its value can either be:

- An array of subcategories (which may further contain their own subcategories)
- An empty array (indicating no subcategories)

### Example Input

```php
$categories = [
    'Electronics' => [
        'Phones' => ['Smartphones', 'Feature phones'],
        'Laptops' => [],
    ],
    'Furniture' => [
        'Beds' => [],
        'Chairs' => ['Office chairs', 'Dining chairs'],
    ],
];
```
