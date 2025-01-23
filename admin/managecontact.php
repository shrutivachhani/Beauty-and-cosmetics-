<?php
include 'header.php'
?>

<div class="container">
        <h1>Manage Contacts</h1>

        

        <table>
            <thead>
                <tr>
                    <th>Contact ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>001</td>
                    <td>Shruti vachhani</td>
                    <td>s.vachhani@gmail.com</td>
                    <td>(+91) 98765 43210</td>
                    <td>Ambika Township, Rajkot</td>
                    <td>
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>Nirali Nandaniya</td>
                    <td>n.nandaniya@gmail.com</td>
                    <td>(+91) 99887 66544</td>
                    <td>oscar sky park, Rajkot</td>
                    <td>
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
                <!-- More rows as needed -->
            </tbody>
        </table>
    </div>
<br>
<br>
<br>

<?php
include 'footer.php'
?>