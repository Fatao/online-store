<?php

namespace App\Models;

/**
 * User is an alias for Customer.
 * Laravel expects App\Models\User by default in some places.
 * We redirect it to Customer which is our actual auth model.
 */
class User extends Customer
{
    // Inherits everything from Customer
}