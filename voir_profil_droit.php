
<?php
    include_once('sys_connexion.php');
?>

<h3><i class="fa fa-angle-right"></i> Liste Des Roles/Pages</h3>

<div class="row mb">
  <!-- page start-->
  <div class="content-panel" style="margin: 15px;">

    <?php if (isset($_SESSION['message'])) { ?>
      <div class="alert alert-<?php echo ($_SESSION['typeMsg']); ?>"> 
        <button type="button" class="close" data-dismiss="alert">×</button>  
        <span>
          <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']);
            unset($_SESSION['typeMsg']); 
          ?>
        </span> 
      </div>
    <?php } ?>

    <?php
      $bareme = $db->prepare('
        SELECT t_role_user.libelle_role, t_pages.code_page 
        FROM bdd_paie.droits_acces 
        INNER JOIN bdd_paie.t_role_user ON t_role_user.id_role = droits_acces.id_role
        INNER JOIN bdd_paie.t_pages ON t_pages.id_page = droits_acces.page_id
      ');
      $bareme->execute();

      $rolesPages = [];

      while($resbareme = $bareme->fetch()) {
          $role = $resbareme['libelle_role'];
          $page = $resbareme['code_page'];

          if (!isset($rolesPages[$role])) {
              $rolesPages[$role] = [];
          }
          $rolesPages[$role][] = $page;
      }
    ?>

    <!-- Tableau stylé comme dans votre fichier -->
    <div class="adv-table" style="margin: 5px;">
      <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
        <thead>
          <tr>
            <th>Role Utilisateur</th>
            <th>Pages</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rolesPages as $role => $pages): ?>
          <tr>
            <td><?php echo htmlspecialchars($role); ?></td>
            <td><?php echo htmlspecialchars(implode(', ', $pages)); ?></td>
            <td>
              <a href="accueil.php?page=Edit_associer_droit&role=<?php echo urlencode($role); ?>">Modifier</a>
 </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>
<!-- page end-->
<br><br><br><br><br><br><br><br><br><br>

