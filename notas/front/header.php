<!-- Segurança-->
<script src="../../js/seg.js"></script>

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
  <i class="fa fa-bars"></i>
</button>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

  <!-- Nav Item - Search Dropdown (Visible Only XS) -->
  <li class="nav-item dropdown no-arrow d-sm-none">
    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-search fa-fw"></i>
    </a>
    <!-- Dropdown - Messages -->
    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
      <form class="form-inline mr-auto w-100 navbar-search">
        <div class="input-group">
          <input type="text" class="form-control bg-light border-0 small" placeholder="Pesquisar..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </li>

  <!-- Nav Item - User Information -->
  <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["user"]; ?></span>
      <i class="fas fa-user rounded-circle" style="font-size: 25px;text-align: center;border-style: solid;width: 40px;height: 40px;line-height: 1.3;"></i>
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalPerfil">
        <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
        Perfil
      </a>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Logout
      </a>
    </div>
  </li>

</ul>




<!-- Modal Perfil -->
<div class='modal fade' id='modalPerfil' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered' role='document'>
    <div class='modal-content'>
      <form id='editarperfil' method='POST' action='<?php echo $caminho1; ?>fun/funUsers.php?fun=editarperfil'>
        <div class='modal-header'>
          <h5 class='modal-title' id='exampleModalLongTitle'>Editar Perfil</h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <div class='modal-body'>
          <div class='form-group'>
            <label for='nomeEdit'>Nome</label>
            <input type='text' class='form-control' value='<?php echo $_SESSION["user"]; ?>' name='nomeEdit' id='nomeEdit'>
          </div>
          <div class='form-group'>
            <label for='loginEdit'>Login</label>
            <input type='text' class='form-control' value='<?php echo $_SESSION["email"]; ?>' name='loginEdit' id='loginEdit'>
          </div>
          <div class='form-group'>
            <label for='loginFluigEdit'>Login Fluig</label>
            <input type='text' class='form-control' value='<?php echo $_SESSION["loginfluig"]; ?>' name='loginFluigEdit' id='loginFluigEdit'>
          </div>
          <div class='form-group'>
            <label for='passFluigEdit'>Senha Fluig</label>
            <input type='password' class='form-control' name='passFluigEdit' id='passFluigEdit'>
          </div>
          <input type='hidden' value='<?php echo $_SESSION["iduser"]; ?>' name='iduser' id='iduser'>
          <input type='hidden' value='http://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo $_SERVER['REQUEST_URI']; ?>' name='caminho' id='caminho'>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
          <input type='submit' class='btn btn-success' name='editPerfil' value='Salvar' />
        </div>
      </form>
    </div>
  </div>
</div>