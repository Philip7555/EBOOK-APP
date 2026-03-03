<?php

class AdminController
{
    public static function requireAdmin(): void
    {
        session_start();

        if (empty($_SESSION['admin'])) {
            header('Location: login.php');
            exit;
        }
    }
}