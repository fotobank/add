<?php
/**
 * This script creates the database 'library_test' to illustrate the examples included in test.php
 * Please run this script before executing test.php
 */
header("Content-Type: text/plain; charset=UTF-8");

require_once "classes/database/exceptions/db-exception.php";
require_once "classes/database/database.php";

/*
 * Change the username and password to connect to your database engine.
 */
$username = "<possibly root>";
$password = "<your password here>";
$database = "library_test";

// connects to the database engine
$db = new Database();

try {
    $db->connect("localhost", $username, $password);
} catch (DBException $e) {
    echo "Error: ". $e->getMessage() . "\n";
    echo "Make sure your username and password are correct.";
    die();
}

// creates and selects the database
go\DB\query("create database if not exists $database");
$db->select($database);

// creates the `authors` table and inserts some records
echo "Creating `authors` table ... ";
go\DB\query("create table if not exists authors (
    id int not null auto_increment primary key,
    name varchar(100) not null
)");
echo "done\n";

echo "Inserting records ... ";
go\DB\query("delete from authors");
go\DB\query("insert into authors(id, name) values(1, 'Arthur C. Clarke')");
go\DB\query("insert into authors(id, name) values(2, 'Isaac Asimov')");
go\DB\query("insert into authors(id, name) values(3, 'Eduardo Mendoza')");
go\DB\query("insert into authors(id, name) values(4, 'Theodore Sturgeon')");
echo "done\n\n";

// creates the `genres` table and inserts some records
echo "Creating `genres` table ... ";
go\DB\query("create table if not exists genres (
    id int not null auto_increment primary key,
    name varchar(100) not null
)");
echo "done\n";

echo "Inserting records ... ";
go\DB\query("delete from genres");
go\DB\query("insert into genres(id, name) values(1, 'Sci-Fi')");
go\DB\query("insert into genres(id, name) values(2, 'Horror')");
go\DB\query("insert into genres(id, name) values(3, 'Comedy')");
go\DB\query("insert into genres(id, name) values(4, 'Software')");
echo "done\n\n";

// creates `books` table and inserts some records
echo "Creating `books` table ... ";
go\DB\query("create table if not exists books (
    id int not null auto_increment primary key,
    title varchar(100) not null,
    author_id int,
    created_on datetime not null,
    updated_on datetime not null
) engine = innodb");
echo "done\n";

echo "Inserting records ... ";
go\DB\query("delete from books");
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(1, %1, %2, now(), now())", array("2001: A Space Odyssey", 1));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(2, %1, %2, now(), now())", array("Rendezvous with Rama", 1));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(3, %1, %2, now(), now())", array("The Songs of Distant Earth", 1));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(4, %1, %2, now(), now())", array("I, Robot", 2));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(5, %1, %2, now(), now())", array("Robot Dreams", 2));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(6, %1, %2, now(), now())", array("The End of Eternity", 2));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(7, %1, %2, now(), now())", array("David Starr, Space Ranger", 2));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(8, %1, %2, now(), now())", array("More Than Human", 4));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(9, %1, %2, now(), now())", array("Sin noticias de Gurb", 3));
go\DB\query("insert into books(id, title, author_id, created_on, updated_on) values(10, %1, %2, now(), now())", array("El asombroso viaje de Pomponio Flato", 3));
go\DB\query("insert into books(id, title, created_on, updated_on) values(11, %1, now(), now())", array("Code Complete"));
echo "done\n\n";


// creates the `books_by_genre` table and inserts some records
echo "Creating `books_by_genre` table ... ";
go\DB\query("create table if not exists books_by_genre (
    id int not null auto_increment primary key,
    book_id int not null,
    genre_id int not null
)");
echo "done\n";

echo "Inserting records ... ";
go\DB\query("delete from books_by_genre");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(1, 1)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(2, 1)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(3, 1)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(4, 1)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(5, 1)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(6, 1)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(7, 1)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(8, 1)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(8, 2)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(9, 3)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(10, 3)");
go\DB\query("insert into books_by_genre(book_id, genre_id) values(11, 4)");
echo "done\n\n";

go\DB\Storage::getInstance()->get()->close();
echo "The process completed successfully!";
