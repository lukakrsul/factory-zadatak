# Factory - Jela Svijeta

This API is built with Laravel, designed to manage and retrieve meals, categories, tags, and ingredients. The API supports multilingual content and allows clients to request specific relationships (e.g., ingredients, tags, and categories) through flexible query parameters.

## Features

- **Retrieve Meals:** Fetch meals with optional filters for tags, ingredients, and categories.
- **Multilingual Support:** Handle translations based on the requested language.
- **Pagination:** Control the number of meals returned per page.
- **Eager Loading:** Use the `with` parameter to include related data like tags, ingredients, and categories.

## Table of Contents

- [Features](#features)
- [Packages Used](#packages-used)
- [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Models & Relationships](#models--relationships)
- [Database Schema](#database-schema)
- [Validation](#validation)
- [Translations](#translations)
- [Error Handling](#error-handling)

## Packages Used

- [Faker](https://fakerphp.org/): For generating fake data in database seeders.
- [Laravel Translatable](https://github.com/Astrotomic/laravel-translatable): For handling translations in models.

## Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/lukakrsul/factory-zadatak.git
    ```

2. **Install the dependencies:**
    ```bash
    composer install
    ```

3. **Configure your `.env` file:**
    ```bash
    cp .env.example .env
    ```
    - Setup your database configuration.

4. **Run database migration and seeder:**
    ```bash
    php artisan migrate --seed
    ```

5. **Start the development server:**
    ```bash
    php artisan serve
    ```

## Usage

- **Example request:**
    ```
    .../meals?per_page=2&tags=4&lang=en_GB&with=category,ingredients,tags&page=1
    ```

- **Example response:**
    ```json
    {
      "meta": {
        "currentPage": 1,
        "totalItems": 4,
        "itemsPerPage": 2,
        "totalPages": 2
      },
      "data": [
        {
          "id": 6,
          "title": "I'm sure.",
          "description": "Who ever saw in my time, but.",
          "status": "created",
          "category": {
            "id": 1,
            "title": "But they.",
            "slug": "aut-aliquid-eveniet"
          },
          "tags": [
            {
              "id": 4,
              "title": "HAVE you.",
              "slug": "nesciunt-maiores-ea"
            },
            {
              "id": 8,
              "title": "Alice as.",
              "slug": "est-voluptatum-repellat"
            },
            {
              "id": 3,
              "title": "The door.",
              "slug": "sapiente-non-et"
            }
          ],
          "ingredients": [
            {
              "id": 15,
              "title": "Alice to.",
              "slug": "dolores-architecto-iusto"
            },
            {
              "id": 22,
              "title": "Five and.",
              "slug": "occaecati-necessitatibus-sed"
            }
          ]
        }
      ],
      "links": {
        "prev": null,
        "next": "http://127.0.0.1:8000/meals?page=2",
        "self": "http://127.0.0.1:8000/meals?page=1"
      }
    }
    ```

## API Endpoints

**Retrieve a paginated list of meals**

**Query parameters:**

- `per_page` (optional): number of meals per page.
- `tags` (optional): filter by tag ID.
- `lang` (required): language code for translation (e.g., `en_GB`, `hr_HR`, `de_DE`).
- `with` (optional): Include related data (comma-separated values, e.g., `category`, `tags`, `ingredients`).
- `page` (optional): Page number of pagination.

## Models & Relationships

- **Meal:**
  - Relationships: `belongsTo` Category, `belongsToMany` Tags, `belongsToMany` Ingredients
- **Category:**
  - Relationships: `hasMany` Meals
- **Tag:**
  - Relationships: `belongsToMany` Meals
- **Ingredient:**
  - Relationships: `belongsToMany` Meals

## Database Schema

| Table             | Columns                             |
|-------------------|-------------------------------------|
| meals             | id, title, description, status, category_id |
| meal_translations | id, meal_id, locale, title, description |
| categories        | id, title, slug                     |
| category_translations | id, category_id, locale, title |
| ingredients       | id, title, slug                     |
| ingredient_translations | id, ingredient_id, locale, title |
| tags              | id, title, slug                     |
| tag_translations  | id, tag_id, locale, title           |
| meal_tag          | meal_id, tag_id                     |
| meal_ingredient   | meal_id, ingredient_id              |

## Validation

- `per_page`: Integer between 1 and 100.
- `tags`: Nullable integer.
- `lang`: Required string.
- `with`: Nullable string.
- `page`: Integer with a minimum value of 1.

## Translations

Translations are handled via the `translate($lang)` method, and available languages are stored in the translation tables.

## Error Handling

If validation fails or any other error occurs, the API returns a 400 or 500 response with an appropriate error message.

**Example Error Response:**
```json
{
    "per_page": [
        "The per_page must be an integer."
    ],
    "lang": [
        "The lang field is required."
    ]
}
