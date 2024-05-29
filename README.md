# Jashn E-commerce Platform

Jashn is a comprehensive e-commerce platform developed using PHP Laravel 8, jQuery, and MySQL. This README file provides an overview of the project, its technical components, and instructions for setting up and running the application.

## Description

Jashn is designed to offer a seamless and dynamic shopping experience. Built on a robust technical stack, the platform ensures high performance, security, and scalability. Key features of Jashn include a versatile payment gateway, advanced order tracking, integrated logistics, and personalized offers with multi-variation options for products.

## Technical Stack

- **Backend Framework:** PHP Laravel 8
- **Frontend Library:** jQuery
- **Database:** MySQL
- **Templating Engine:** Blade (Laravel)
- **ORM:** Eloquent (Laravel)
- **Payment Gateway:** Integrated secure payment APIs
- **Delivery System:** Custom logistics management
- **Order Tracking:** Real-time updates and notifications

## Features

1. **User Authentication:** Secure user registration and login using Laravel’s built-in authentication system.
2. **Product Management:** Comprehensive product catalog with support for multi-variation options (color, size).
3. **Shopping Cart:** Dynamic and responsive shopping cart using jQuery.
4. **Order Processing:** Efficient order management system with real-time tracking.
5. **Payment Integration:** Multiple payment options with secure transactions.
6. **Logistics:** Own logistics system for reliable and timely delivery.
7. **Offers and Discounts:** Dynamic offers based on product selection or categories.
8. **Responsive Design:** Optimized for various devices to provide a consistent user experience.

## Installation

### Prerequisites

- PHP >= 7.3
- Composer
- MySQL
- Node.js and npm

### Steps

1. **Clone the Repository:**
    ```bash
    git clone https://github.com/your-username/jashn.git
    cd jashn
    ```

2. **Install Dependencies:**
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Environment Setup:**
    - Copy `.env.example` to `.env` and update the configuration settings (database, mail, etc.)
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database Setup:**
    - Create a new MySQL database and update `.env` with your database credentials.
    ```bash
    php artisan migrate --seed
    ```

5. **Run the Application:**
    ```bash
    php artisan serve
    ```

6. **Access the Application:**
    - Open your web browser and go to `http://localhost:8000`

## Development

### Compiling Assets

- To compile CSS and JavaScript assets, use Laravel Mix:
    ```bash
    npm run dev
    ```

### Running Tests

- Run the test suite to ensure everything is working correctly:
    ```bash
    php artisan test
    ```

## Contribution

Contributions are welcome! Please fork the repository and submit pull requests for any enhancements or bug fixes.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

---

For any queries or further assistance, please contact us at support@jashn.com.

Thank you for choosing Jashn!
