<div class="sidebar-wrapper">
    <ul class="nav">
        <li class="<?php echo ($action == 'dashboard') ? 'active' : '' ?>">
            <a href="<?php echo DISPATCH_URL ?>users/dashboard">
                <i class="material-icons">dashboard</i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="<?php echo ($action == 'settings') ? 'active' : '' ?>">
            <a href="<?php echo DISPATCH_URL ?>users/settings">
                <i class="material-icons">settings</i>
                <p>Settings</p>
            </a>
        </li>
        <li class="<?php echo ($controller == 'Orders') ? 'active' : '' ?>">
            <a href="./table.html">
                <i class="material-icons">content_paste</i>
                <p>Orders</p>
            </a>
        </li>
        <li class="<?php echo ($controller == 'Drivers') ? 'active' : '' ?>">
            <a href="./typography.html">
                <i class="material-icons">account_box</i>
                <p>Drivers</p>
            </a>
        </li>
        <li class="<?php echo ($controller == 'Reports') ? 'active' : '' ?>">
            <a href="./icons.html">
                <i class="material-icons">library_books</i>
                <p>Reports</p>
            </a>
        </li>
    </ul>
</div>