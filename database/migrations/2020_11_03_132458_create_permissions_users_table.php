<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // -- phpMyAdmin SQL Dump
        // -- version 5.0.2
        // -- https://www.phpmyadmin.net/
        // --
        // -- Host: 127.0.0.1:3306
        // -- Generation Time: Aug 28, 2022 at 05:35 PM
        // -- Server version: 5.7.31
        // -- PHP Version: 7.4.9

        // SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
        // START TRANSACTION;
        // SET time_zone = "+00:00";


        // /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        // /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
        // /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
        // /*!40101 SET NAMES utf8mb4 */;

        // --
        // -- Database: `24flights`
        // --

        // -- --------------------------------------------------------

        // --
        // -- Table structure for table `permission_user`
        // --

        // DROP TABLE IF EXISTS `permission_user`;
        // CREATE TABLE IF NOT EXISTS `permission_user` (
        // `user_id` bigint(20) UNSIGNED NOT NULL,
        // `permission_id` bigint(20) UNSIGNED NOT NULL,
        // `created_at` timestamp NULL DEFAULT NULL,
        // `updated_at` timestamp NULL DEFAULT NULL,
        // PRIMARY KEY (`user_id`,`permission_id`),
        // KEY `permission_user_permission_id_foreign` (`permission_id`)
        // ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        // COMMIT;

        // /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        // /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
        // /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
        // Schema::create('permission_user', function (Blueprint $table) {
        //     $table->primary(['user_id', 'permission_id']);
        //     $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        //     $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
    }
}
