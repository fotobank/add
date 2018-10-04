<?php
/**
 * This script illustrates the most common uses of the DBQuery class:
 * 
 * 1. Selecting a single record.
 * 2. Selecting multiple records.
 * 3. Accessing columns.
 * 4. Saving records.
 * 5. Refreshing records.
 * 6. Deleting records.
 */
header("Content-Type: text/plain; charset=UTF-8");

require_once "classes/database/database.php";
require_once "classes/database/db-query.php";

/*
 * Change the username and password to connecto to your database.
 */
$username = "<possibly root>";
$password = "<your password here>";
$database = "library_test";

try {
    $db = new Database($database, $username, $password);
} catch (DBException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Make sure your username and password are correct and exists the $database database .\n";
    echo "You may need to run the 'create-database.php' script to create the database.";
    die();
}

/*
 * Selects a single row.
 * Note that you do not need to create an instance of DBQuery. The 'query' function does this for you.
 */
$row = go\DB\query("
select
    b.id,
    b.title,
    a.name
from books as b
inner join authors as a on a.id = b.author_id
and b.id = 4");
echo "Selecting a single row...\n";
echo "Title : " . $row->title . "\n";
echo "Author: " . $row->name . "\n\n\n";

// Selects multiple rows.
// Note that you can use the same function 'query' to get a single or multiple rows.
$rows = go\DB\query("
select
    b.id,
    g.name as genre,
    ifnull(a.name, '<Unknown>') as author,
    b.title
from books_by_genre as bg
inner join genres as g on g.id = bg.genre_id
inner join books as b on b.id = bg.book_id
left join authors as a on a.id = b.author_id
order by g.name, b.title");

echo "Selecting multiple rows...\n";
echo str_pad("Book Id", 10) . str_pad("Genre", 10) . str_pad("Author", 20) . "Title\n";
echo str_repeat("-", 46) . "\n";
foreach ($rows as $row) {
    echo str_pad($row->id, 10) . str_pad($row->genre, 10) . str_pad($row->author, 20) . $row->title . "\n";
}
echo "[ Number of rows: " . count($rows) . " ]\n\n\n";

/*
 * You can access the columns by three ways:
 * 
 * 1. Through the column name. For example:
 *      $row->column
 * 
 * 2. Through the array access. For example:
 *      $row['column'] or
 *      $row['table.column']
 * 
 * 3. Through the index. For example:
 *      $row[3]  // Index from 0 onwards.
 */
$row = go\DB\query("
select
	b.id,
	b.title,
	group_concat(g.name) as genres,
	a.id,
	a.name
from books as b
left join books_by_genre as bg on bg.book_id = b.id
left join genres as g on g.id = bg.genre_id
left join authors as a on a.id = b.author_id
where b.id = 8
group by b.id
order by b.title");

echo "Accessing columns...\n";
// accessing columns by array
echo "Book id    : " . $row['b.id'] . "\n";
echo "Book title : " . $row['title'] . "\n";
// accessing columns by name
echo "Genres     : " . $row->genres . "\n";
// accessing columns by index
echo "Author id  : " . $row[3] . "\n";
echo "Author name: " . $row[4] . "\n\n\n";

/*
 * Saving records.
 * Note that primary keys are present in the query.
 * This is because the class needs to know what records must be updated.
 * 
 * The 'save' method not only updates records, but also inserts new records when needed.
 * In the example below, the selected book doesn't have author, so the system creates a new author record.
 * 
 * If the fields 'updated_on' and 'created_on' are present in the table, they are updated automatically.
 */
 
// creates the record if it does not exist
$row = go\DB\query("select count(*) from books where id = 11");
if (!$row[0]) {
    go\DB\query("insert into books(id, title, created_on, updated_on) values(11, %1, now(), now())", array("Code Complete"));
}

// gets the record and saves the changes
$row = go\DB\query("
select
    b.id as book_id,
    b.title,
    b.created_on,
    b.updated_on,
    a.id as author_id,
    a.name as author
from books as b
left join authors as a on a.id = b.author_id
where b.id = 11");

echo "Saving records ...\n";
$row->setDebugMode(TRUE);  // This line lets us to know what happens behind the scene :)
$row->title = "Code Complete 2";
$row->author = "Steve McConnell";
$row->save();
echo "done\n\n\n";

/*
 * Refreshing records.
 * Refreshes the previous row.
 */
echo "Refreshing records ...\n";
$row->setDebugMode(FALSE);
$row->refresh();
echo "Book id   : " . $row->book_id . "\n";
echo "Book title: " . $row->title . "\n";
echo "Created on: " . $row->created_on . "\n";
echo "Updated on: " . $row->updated_on . "\n";
echo "Author    : " . $row->author . "\n\n\n";

/*
 * Deleting records.
 * Deletes the previous book.
 */
echo "Deleting records ...\n";
$row->setDebugMode(TRUE);  // let me see what is happening
$row->delete(TRUE);
echo "done\n";

go\DB\Storage::getInstance()->get()->close();









