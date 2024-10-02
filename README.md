# Lithe Hash

A robust module for securely hashing passwords using Bcrypt. This module simplifies the process of creating, verifying, and managing password hashes, ensuring security best practices are followed.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
  - [Importing the Class](#importing-the-class)
  - [Creating a Hash](#creating-a-hash)
  - [Verifying a Hash](#verifying-a-hash)
  - [Checking if a Hash Needs Rehashing](#checking-if-a-hash-needs-rehashing)
- [Understanding Bcrypt](#understanding-bcrypt)
- [Handling Exceptions](#handling-exceptions)
- [Testing](#testing)
- [License](#license)

## Installation

To install the `lithemod/hash` package, you can use Composer. Run the following command in your terminal:

```bash
composer require lithemod/hash
```

This will add the package to your project's dependencies, allowing you to use the `Hash` class in your application.

## Usage

### Importing the Class

Before using the `Hash` class, you must import it in your PHP file:

```php
use Lithe\Support\Security\Hash;
```

### Creating a Hash

To create a hash from a password, use the `make` method. The method accepts a password and an optional array of options:

```php
$hash = Hash::make('your_password', ['cost' => 10]);
```

- **Parameters**:
  - `string $value`: The password to be hashed.
  - `array $options`: Optional parameters (e.g., cost) to adjust the hashing algorithm.
- **Returns**: A hashed string that can be stored in a database.

**Example**:
```php
$password = 'my_secure_password';
$hash = Hash::make($password, ['cost' => 12]);
echo "Hashed Password: " . $hash;
```

### Verifying a Hash

To check if a given password matches the hash, use the `check` method:

```php
$isValid = Hash::check('your_password', $hash);
if ($isValid) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}
```

- **Parameters**:
  - `string $value`: The password to verify.
  - `string $hash`: The hashed password to compare against.
- **Returns**: `true` if the password matches the hash; `false` otherwise.

**Example**:
```php
if (Hash::check('my_secure_password', $hash)) {
    echo 'Password is correct!';
} else {
    echo 'Password is incorrect!';
}
```

### Checking if a Hash Needs Rehashing

You can determine if a hash needs to be rehashed (for example, if you change the cost factor) using the `needsRehash` method:

```php
$needsRehash = Hash::needsRehash($hash, ['cost' => 14]);
if ($needsRehash) {
    // Rehash with a new cost
    $hash = Hash::make('your_password', ['cost' => 14]);
}
```

- **Parameters**:
  - `string $hash`: The hashed password to evaluate.
  - `array $options`: Optional parameters to specify the cost.
- **Returns**: `true` if the hash needs to be rehashed; `false` otherwise.

**Example**:
```php
if (Hash::needsRehash($hash, ['cost' => 15])) {
    $hash = Hash::make('my_secure_password', ['cost' => 15]);
    echo "Rehashed Password: " . $hash;
}
```

## Understanding Bcrypt

Bcrypt is a widely-used password hashing function designed to be slow and computationally intensive, making it resistant to brute-force attacks. By using a configurable cost factor, Bcrypt allows you to increase the difficulty of hashing as hardware becomes faster.

- **Cost Factor**: The cost factor determines the computational complexity of hashing a password. It represents the number of iterations of the hashing algorithm. A higher cost means more security but also increases processing time. The recommended range is between 10 and 12 for most applications.

## Handling Exceptions

The `make` method throws an `InvalidArgumentException` if the cost is set outside the valid range (4 to 31). You should handle this in your code to ensure robustness:

```php
try {
    $hash = Hash::make('your_password', ['cost' => 3]); // Invalid cost
} catch (\InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Testing

To ensure that your installation of the `lithemod/hash` module works correctly, you can run the included unit tests. If you have PHPUnit installed, execute the following command in your project directory:

```bash
./vendor/bin/phpunit
```

This will run the tests defined in the `Tests` namespace and validate the functionality of the `Hash` class.

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.