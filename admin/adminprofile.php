<?php
include 'header.php'
?>


<div class="container">
        <div class="profile-header">
            <img src="images/user.png" alt="Admin Picture">
            <div>
                <h1>Admin Name</h1>
                <p>Email: admin@example.com</p>
                <p>Role: Administrator</p>
                <p>Joined: January 2023</p>
            </div>
        </div>
        <div class="stats">
            <h2>System Statistics</h2>
            <ul>
                <li>Total Users: 1200</li>
                <li>Total Posts: 3500</li>
                <li>Active Sessions: 45</li>
            </ul>
        </div>
        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <ul>
                <li>Updated user roles.</li>
                <li>Deleted spam accounts.</li>
                <li>Reviewed system performance reports.</li>
            </ul>
        </div>
        <div class="admin-actions">
            <button>Manage Users</button>
            <button>View Reports</button>
            <button>System Settings</button>
        </div>
    </div>
    <br>
<br>
<br>
<?php
include 'footer.php'
?>