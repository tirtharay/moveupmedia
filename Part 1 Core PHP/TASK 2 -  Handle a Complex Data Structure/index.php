<?php
/**
 * Function to flatten a nested array of categories into a simple list of category names.
 *
 * @param array $categories The original array with categories and subcategories.
 * @return array A flat array containing all category names.
 */
function flattenCategories(array $categories): array {
    // Initialize an empty array to hold our flattened category names
    $flattened = [];

    // Loop through each item in the categories array
    foreach ($categories as $category => $subcategories) {
        // Add the current category to the flattened list
        $flattened[] = $category;

        // Check if the current category has any subcategories
        if (is_array($subcategories) && !empty($subcategories)) {
            // Recursively flatten the subcategories and merge them into the main list
            $flattened = array_merge($flattened, flattenCategories($subcategories));
        }
    }

    // Return the final flattened list of category names
    return $flattened;
}

// Nested categories array
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

// Call the function and see the result
$flattenedCategories = flattenCategories($categories);

// Display the flattened array
print_r($flattenedCategories);
?>
