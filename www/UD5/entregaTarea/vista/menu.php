<nav class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/index.php">
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/init.php">
                    Inicializar (mysqli)
                </a>
            </li>
            <?php 
            if(esAdmin()) {?>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/usuarios/usuarios.php">
                    Lista de usuarios (PDO)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/usuarios/nuevoUsuarioForm.php">
                    Nuevo usuario (PDO)
                </a>
            </li>
            <?php }?>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/tareas/tareas.php">
                    Lista de tareas (mysqli)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/tareas/nuevaForm.php">
                    Nueva tarea (mysqli)
                </a>
            </li>
            <?php if(esAdmin()) {?>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/tareas/buscaTareas.php">
                   Buscador de tareas (PDO)
                </a>
            </li>
            <?php }?>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/logout.php">
                   Salir
                </a>
            </li>
        </ul>
        <form class="m-3 w-50" method="POST" action="/UD5/entregaTarea/tema.php">
            <select id="tema" name="tema" class="form-select mb-2" aria-label="Selector de tema">
                <option value="light" <?php echo !isset($_COOKIE['tema']) || $_COOKIE['tema'] == 'light' ? 'selected' : ''?>>Claro</option>
                <option value="dark" <?php echo isset($_COOKIE['tema']) && $_COOKIE['tema'] == 'dark' ? 'selected' : ''?>>Oscuro</option>
                <option value="auto" <?php echo isset($_COOKIE['tema']) && $_COOKIE['tema'] == 'auto' ? 'selected' : ''?>>Automático</option>
            </select>
            <button type="submit" class="btn btn-primary w-100">Aplicar</button>
        </form>
    </div>
</nav>