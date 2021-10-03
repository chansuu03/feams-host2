<?php $user_mgmt = ['USR', 'ROLE', 'PERM'];?>
<?php if(count(array_intersect($perms, $user_mgmt)) > 1):?>
  <?php $usr = ['users', 'roles', 'permissions']?>
  <li class="nav-item has-treeview <?= in_array($active, $usr) ? 'menu-open' : ''?>">
    <a href="#" class="nav-link <?= in_array($active, $usr) ? 'active' : ''?>">
      <i class="nav-icon fas fa-users"></i>
      <p>
        User Management
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="margin-left: 15px;">
      <?php if(in_array('USR', $perms)):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/users')?>" class="nav-link <?= $active=="users" ? 'active': ''?>">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Users
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('ROLE', $perms)):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/roles')?>" class="nav-link <?= $active=="roles" ? 'active': ''?>">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>
                    Roles
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('PERM', $perms)):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/permissions')?>" class="nav-link <?= $active=="permissions" ? 'active': ''?>">
                <i class="nav-icon fas fa-universal-access"></i>
                <p>
                    Permissions
                </p>
            </a>
        </li>
      <?php endif;?>
    </ul>
  </li>
<?php endif;?>

<?php $contents = ['ANN', 'SLID', 'NEWS']; $cont_access = false;?>
<?php if(count(array_intersect($perms, $contents)) > 1):?>
  <?php $cont_access = true;?>
  <?php $cnt = ['announcements', 'sliders', 'news']?>
  <!-- Content Management -->
  <li class="nav-item has-treeview <?= in_array($active, $cnt) ? 'menu-open' : ''?>">
    <a href="#" class="nav-link <?= in_array($active, $cnt) ? 'active' : ''?>">
      <i class="nav-icon fas fa-info-circle"></i>
      <p>
        Content Management
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="margin-left: 15px;">
      <?php if(in_array('ANN', $perms)):?>
        <!-- Announcements -->
        <li class="nav-item">
            <a href="<?= base_url('admin/announcements')?>" class="nav-link <?= $active=="announcements" ? 'active': ''?>">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>
                    Announcements
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('SLID', $perms)):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/sliders')?>" class="nav-link <?= $active=="sliders" ? 'active': ''?>">
                <i class="nav-icon fas fa-sliders-h"></i>
                <p>
                    Sliders
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('NEWS', $perms)):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/news')?>" class="nav-link <?= $active=="news" ? 'active': ''?>">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                    News and Events
                </p>
            </a>
        </li>
      <?php endif;?>
    </ul>
  </li>
<?php endif;?>

<?php if(!$cont_access):?>
  <!-- Announcements -->
  <li class="nav-item">
      <a href="<?= base_url('admin/announcements')?>" class="nav-link <?= $active=="announcements" ? 'active': ''?>">
          <i class="nav-icon fas fa-bullhorn"></i>
          <p>
              Announcements
          </p>
      </a>
  </li>
  <!-- News -->
  <li class="nav-item">
      <a href="<?= base_url('admin/news')?>" class="nav-link <?= $active=="news" ? 'active': ''?>">
          <i class="nav-icon fas fa-newspaper"></i>
          <p>
              News and Events
          </p>
      </a>
  </li>
<?php endif;?>

<?php $elec = ['ELEC', 'POS', 'CAN']; $elec_access = false;?>
<?php if(count(array_intersect($perms, $elec)) > 1):?>
  <?php $elec_access = true;?>
  <?php $els = ['elections', 'positions', 'elec_positions', 'candidates', 'voting']?>
  <!-- Election Management -->
  <li class="nav-item has-treeview <?= in_array($active, $els) ? 'menu-open' : ''?>">
    <a href="#" class="nav-link <?= in_array($active, $els) ? 'active' : ''?>">
      <i class="nav-icon fas fas fa-vote-yea"></i>
      <p>
        Election Management
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="margin-left: 15px;">
      <?php if(in_array('ELEC', $perms)):?>
        <!-- Elections -->
        <li class="nav-item">
            <a href="<?= base_url('admin/election')?>" class="nav-link <?= $active=="elections" ? 'active': ''?>">
                <i class="nav-icon fas fa-poll-h"></i>
                <p>
                    Elections
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('POS', $perms)):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/electoral-positions')?>" class="nav-link <?= $active=="elec_positions" ? 'active': ''?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Electoral Positions
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('POS', $perms)):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/positions')?>" class="nav-link <?= $active=="positions" ? 'active': ''?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Assign Positions
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('CAN', $perms)):?>
        <li class="nav-item">
            <a href="<?= base_url('admin/candidates2')?>" class="nav-link <?= $active=="candidates" ? 'active': ''?>">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                    Candidates
                </p>
            </a>
        </li>
      <?php endif;?>
      <li class="nav-item">
          <a href="<?= base_url('votes2')?>" class="nav-link <?= $active=="voting" ? 'active': ''?>">
              <i class="nav-icon fas fa-vote-yea"></i>
              <p>
                  Voting
              </p>
          </a>
      </li>
    </ul>
  </li>
<?php endif;?>

<?php if(!$elec_access):?>
  <li class="nav-item">
      <a href="<?= base_url('votes2')?>" class="nav-link <?= $active=="voting" ? 'active': ''?>">
          <i class="nav-icon fas fa-vote-yea"></i>
          <p>
              Voting
          </p>
      </a>
  </li>
<?php endif;?>

<?php $pay_mgmt = ['CONT', 'PAY']; $payMgmt_access = false;?>
<?php if(count(array_intersect($perms, $pay_mgmt)) >= 1):?>
  <?php $payMgmt_access = true;?>
  <?php $pays = ['contributions', 'payments', 'payment_method', 'payment_feedback']?>
  <!-- Payment Management -->
  <li class="nav-item has-treeview <?= in_array($active, $pays) ? 'menu-open' : ''?>">
    <a href="#" class="nav-link <?= in_array($active, $pays) ? 'active' : ''?>">
      <i class="nav-icon fas fa-money-check"></i>
      <p>
        Payment Management
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="margin-left: 15px;">
      <?php if(in_array('CONT', $perms)):?>
        <!-- Contributions -->
        <li class="nav-item">
            <a href="<?= base_url('admin/contributions')?>" class="nav-link <?= $active=="contributions" ? 'active': ''?>">
                <i class="nav-icon fas fa-hand-holding-usd"></i>
                <p>
                    Contributions
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('PAY', $perms)):?>
        <!-- Payment Methods -->
        <li class="nav-item">
            <a href="<?= base_url('admin/payment-methods')?>" class="nav-link <?= $active=="payment_method" ? 'active': ''?>">
                <i class="nav-icon fas fa-hand-holding-usd"></i>
                <p>
                  Payment Methods
                </p>
            </a>
        </li>
      <?php endif;?>
      <?php if(in_array('PAY', $perms)):?>
        <!-- Feedbacks -->
        <li class="nav-item">
            <a href="<?= base_url('admin/payment-feedbacks')?>" class="nav-link <?= $active=="payment_feedback" ? 'active': ''?>">
                <i class="nav-icon fas fa-comment"></i>
                <p>
                  Feedbacks
                </p>
            </a>
        </li>
      <?php endif;?>
      <!-- Payments -->
      <li class="nav-item">
          <a href="<?= base_url('payments')?>" class="nav-link <?= $active=="payments" ? 'active': ''?>">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                  Payments
              </p>
          </a>
      </li>
    </ul>
  </li>
<?php endif;?>

<?php if(!$payMgmt_access):?>
  <!-- Payments -->
  <li class="nav-item">
      <a href="<?= base_url('payments')?>" class="nav-link <?= $active=="payments" ? 'active': ''?>">
          <i class="nav-icon fas fa-money-bill-alt"></i>
          <p>
              Payments
          </p>
      </a>
  </li>
<?php endif;?>

<li class="nav-item">
    <a href="<?= base_url('constitution')?>" class="nav-link <?= $active=="constitution" ? 'active': ''?>">
        <i class="nav-icon fas fa-scroll"></i>
        <p>
            Constitution
        </p>
    </a>
</li>

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

<?php $reports = ['REPO'];?>
<?php if(count(array_intersect($perms, $reports)) >= 1):?>
  <?php $repo = ['login_repo', 'pay_repo']?>
  <!-- Reports -->
  <!-- Content Management -->
  <li class="nav-item has-treeview <?= in_array($active, $repo) ? 'menu-open' : ''?>">
    <a href="#" class="nav-link <?= in_array($active, $repo) ? 'active' : ''?>">
      <i class="nav-icon fas fa-chart-bar"></i>
      <p>
        Reports
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="margin-left: 15px;">
      <!-- Login -->
      <li class="nav-item">
          <a href="<?= base_url('admin/reports/login')?>" class="nav-link <?= $active=="login_repo" ? 'active': ''?>">
              <i class="nav-icon fas fa-sign-in-alt"></i>
              <p>
                  Login Reports
              </p>
          </a>
      </li>
      <!-- Payments -->
      <li class="nav-item">
          <a href="<?= base_url('admin/reports/payments')?>" class="nav-link <?= $active=="pay_repo" ? 'active': ''?>">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                  Payment Reports
              </p>
          </a>
      </li>
    </ul>
  </li>
<?php endif;?>
