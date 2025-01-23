<?php
// Include the header
include_once("userheader.php");
// Include the database connection
include_once("db_connection.php");

?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>About us</h1>
                </div>
            </div>
            <div class="col-lg-7"></div>
        </div>
    </div>
</div>
<!-- End Hero Section -->
<div class="container">
    <br>
    <div class="row p-4">
        <div class="col-12">
            <?php
            // Query to select content from the 'about_us' table
            $q = "SELECT * FROM about_us WHERE id = 1"; // Assuming 'id=1' for the content you want to display
            $result = mysqli_query($con, $q); // Execute the query
            
            // Loop through and display the content
            while ($r = mysqli_fetch_assoc($result)) {
                echo $r['content']; // Output the 'content' field from the table
            }
            ?>
        </div>
    </div>
</div>

<?php
// Include the footer
include_once("footer.php");
?>
