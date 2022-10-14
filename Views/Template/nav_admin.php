<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media() ?>/images/avatar.png" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombrePersona']; ?></p>
            <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombreRol'] == ROLADMINEMP ? "Administrador <br> de Empresas": $_SESSION['userData']['nombreRol'] ; ?></p>
        </div>
    </div>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item" href="<?= base_url() ?>" target="_blank">
                <i class="app-menu__icon fa fas fa-globe" aria-hidden="true"></i>
                <span class="app-menu__label">Ver sitio web</span>
            </a>
        </li>
        <?php if ($data['rol-personal'] == "Jefa") { ?>
            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
                    <span class="app-menu__label">Tienda</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="<?= base_url() ?>/productos"><i class="icon fa fa-circle-o"></i>Productos</a></li>
                    <li><a class="treeview-item" href="<?= base_url() ?>/categorias"><i class="icon fa fa-circle-o"></i>Categorías</a></li>
                    <li><a class="treeview-item" href="<?= base_url() ?>/cupones"><i class="icon fa fa-circle-o"></i>Cupones</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-users" aria-hidden="true"></i>
                    <span class="app-menu__label">Clientes</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="<?= base_url() ?>/usuarios"><i class="icon fa fa-circle-o"></i>Usuarios</a></li>
                    <li><a class="treeview-item" href="<?= base_url() ?>/negocios"><i class="icon fa fa-circle-o"></i>Negocios-Clientes</a></li>
                </ul>
            </li>
        <?php } else if ($data['rol-personal'] == "Contador Auditor" || $data['rol-personal'] == "Administrador de Empresas" || $data['rol-personal'] == "Analista-financiero") { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url() ?>/recibos">
                    <i class="app-menu__icon fas fa-file-invoice-dollar" aria-hidden="true"></i>
                    <span class="app-menu__label">Recibos de Pedidos</span>
                </a>
            </li>
        <?php } ?>
        <li>
            <a class="app-menu__item" href="<?= base_url() ?>/suscripciones">
                <i class="app-menu__icon fas fa-tags" aria-hidden="true"></i>
                <span class="app-menu__label">Suscripcciones</span>
            </a>
        </li>
    </ul>
</aside>
