<!-- Users -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'USR'):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/users')?>" class="nav-link <?= $active=="users" ? 'active': ''?>">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Users
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>

<!-- Roles -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'ROLE'):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/roles')?>" class="nav-link <?= $active=="roles" ? 'active': ''?>">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>
                    Roles
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>

<!-- Permissions -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'PERM'):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/permissions')?>" class="nav-link <?= $active=="permissions" ? 'active': ''?>">
                <i class="nav-icon fas fa-universal-access"></i>
                <p>
                    Permissions
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>

<!-- Announcements -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'ANN'):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/announcements')?>" class="nav-link <?= $active=="announcements" ? 'active': ''?>">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>
                    Announcements
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>

<li class="nav-item">
    <a href="<?= base_url('discussions')?>" class="nav-link <?= $active=="discussions" ? 'active': ''?>">
        <i class="nav-icon fas fa-comments"></i>
        <p>
            Discussions
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="<?= base_url('file_sharing')?>" class="nav-link <?= $active=="files" ? 'active': ''?>">
        <i class="nav-icon fas fa-file-upload"></i>
        <p>
            File Sharing
        </p>
    </a>
</li>

<!-- Files -->
<!-- <?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'FILES'):?>
        <li class="nav-item">
            <a href="<?= base_url('files')?>" class="nav-link <?= $active=="files" ? 'active': ''?>">
                <i class="nav-icon fas fa-file"></i>
                <p>
                    Files
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?> -->

<!-- File Categories -->
<!-- <?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'FICAT'):?>
        <li class="nav-item">
            <a href="<?= base_url('files/categories')?>" class="nav-link <?= $active=="filecat" ? 'active': ''?>">
                <i class="nav-icon fas fa-file"></i>
                <p>
                    File Categories
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?> -->

<!-- Sliders -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'SLID'):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/sliders')?>" class="nav-link <?= $active=="sliders" ? 'active': ''?>">
                <i class="nav-icon fas fa-sliders-h"></i>
                <p>
                    Sliders
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>

<!-- Elections -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'ELEC'):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/elections')?>" class="nav-link <?= $active=="elections" ? 'active': ''?>">
                <i class="nav-icon fas fa-vote-yea"></i>
                <p>
                    Elections
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>

<!-- Positions -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'POS'):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/positions')?>" class="nav-link <?= $active=="positions" ? 'active': ''?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Positions
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>

<!-- Candidates -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'CAN'):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/candidates')?>" class="nav-link <?= $active=="candidates" ? 'active': ''?>">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                    Candidates
                </p>
            </a>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>

<li class="nav-item">
    <a href="<?= base_url('voting')?>" class="nav-link <?= $active=="voting" ? 'active': ''?>">
        <i class="nav-icon fas fa-vote-yea"></i>
        <p>
            Voting
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="<?= base_url('constitution')?>" class="nav-link <?= $active=="constitution" ? 'active': ''?>">
        <i class="nav-icon fas fa-scroll"></i>
        <p>
            Constitution
        </p>
    </a>
</li>

<!-- Candidates -->
<?php foreach($rolePermission as $rolePerms):?>
    <?php $access = false;?>
    <?php if($rolePerms['perm_mod'] == 'REPO'):?>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                Reports
                <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url()?>/admin/reports/login" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Login</p>
                    </a>
                </li>
            </ul>
        </li>
        <?php $access = true;?>
    <?php endif;?>
    <?php if($access){
        break;
    }?>
<?php endforeach;?>