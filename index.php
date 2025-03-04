<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./source/css/styles.css">
    <title>Library System</title>
</head>

<body>
    <nav
        class="navbar navbar-expand-sm navbar-toggleable-sm bg-cadium box-shadow d-flex justify-content-between text-white px-3 align-items-center p-3">
        <div class="d-flex flex-wrap align-items-center">
            <div class="ms-1">
                <h3 class="fs-5 mb-0 text-white">Library Data Preview</h3>
                <p class="fs-6 lead mb-0 text-white">V1.0.0</p>
            </div>
        </div>
        <div class="d-flex flex-wrap align-items-center">
            <p class="text-white-50 mb-0" id="time">00:00</p>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row row-cols-1">

            <!--Borrowed Books-->
            <div class="col">
                <h3>Borrowed Books</h3>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>MemberID</th>
                            <th>LastName</th>
                            <th>BookID</th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>BorrowDate</th>
                            <th>Due</th>
                            <th>Date Returned</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT M.MemberID, M.FirstName, M.LastName, 
                        B.BookID, B.Title, B.ISBN, 
                        BR.BorrowDate, BR.DueDate, BR.ReturnDate
                        FROM BorrowingRecords BR
                        JOIN Books B ON BR.BookID = B.BookID
                        JOIN Members M ON BR.MemberID = M.MemberID
                        ORDER BY B.BookID, BR.BorrowDate;
                        ";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['MemberID'] . "</td>";
                                echo "<td>" . $row['LastName'] . "</td>";
                                echo "<td>" . $row['BookID'] . "</td>";
                                echo "<td>" . $row['Title'] . "</td>";
                                echo "<td>" . $row['ISBN'] . "</td>";
                                echo "<td>" . $row['BorrowDate'] . "</td>";
                                echo "<td>" . $row['DueDate'] . "</td>";
                                echo "<td>" . $row['ReturnDate'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!--Books Database-->
            <div class="col mt-3 border mb-5">
                <div class="row row-cols-2">
                    <div class="col mt-2">
                        <div class="border-bottom bg-cadium p-2 rounded rounded-2">
                            <h3 class="text-white mb-0">Books</h3>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>ISBN</th>
                                    <th>Published</th>
                                    <th>Author</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT B.Title, B.ISBN, B.PublishedYear, CONCAT(A.FirstName, ' ', A.LastName) AS Author
                                FROM Books B
                                JOIN BookAuthors BA ON B.BookID = BA.BookID
                                JOIN Authors A ON BA.AuthorID = A.AuthorID
                                ORDER BY B.Title;";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['Title'] . "</td>";
                                        echo "<td>" . $row['ISBN'] . "</td>";
                                        echo "<td>" . $row['PublishedYear'] . "</td>";
                                        echo "<td>" . $row['Author'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No records found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>


                    <!----Students Database-->
                    <div class="col mt-2">
                        <div
                            class="border-bottom bg-cadium p-2 rounded rounded-2 d-flex justify-content-between align-items-center">
                            <h3 class="text-white mb-0">Students</h3>

                            <form method="GET" class="input-group ms-5">
                                <input type="text" class="form-control" name="search" placeholder="Search by Last Name"
                                    aria-label="Search by Last Name" required>
                                <button class="btn btn-warning" type="submit">Search</button>
                            </form>

                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>MemberID</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Book Title</th>
                                </tr>
                            </thead>
                            <tbody id="students-table">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script src="./source/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>