# Cielo Tico - Sistema de Reservas de Tours

Sistema web completo para la gestión de tours y reservas de Cielo Tico, una empresa de turismo en Costa Rica.

## Características

### Para Usuarios
- Registro e inicio de sesión de usuarios
- Visualización de tours disponibles
- Sistema de reservas de tours
- Gestión de reservas personales
- Perfil de usuario editable
- Formulario de contacto

### Para Administradores
- Panel de administración
- Gestión de usuarios
- Gestión de tours
- Control de reservas
- Visualización de estadísticas
- Gestión de testimonios

### Características Técnicas
- Diseño responsive y moderno
- Navegación intuitiva
- Sistema de roles (usuario/administrador)
- Validación de formularios
- Manejo seguro de sesiones
- Backup y restauración de base de datos

## Tecnologías Utilizadas

### Frontend
- HTML5
- CSS3 (con diseño responsive)
- JavaScript
- Font Awesome para iconos
- Google Fonts (Ubuntu)

### Backend
- PHP 8.x
- MySQL/MariaDB
- PDO para conexiones seguras
- Sistema de sesiones PHP

### Herramientas
- XAMPP (Apache + MySQL + PHP)
- Git para control de versiones

## Requisitos de Instalación

1. XAMPP instalado (versión 8.0 o superior)
2. Git (opcional, para clonar el repositorio)
3. Navegador web moderno

## Instalación

1. Clona el repositorio en tu carpeta htdocs de XAMPP:
```bash
cd /ruta/a/tu/xampp/htdocs
git clone https://github.com/WhizJeff/Project_cielo_tico.git cielotico
```

2. Configura la base de datos:
   - Abre phpMyAdmin (http://localhost/phpmyadmin)
   - Crea una base de datos llamada `cielotico_db`
   - Importa el archivo `sql/database.sql`

3. Configura el archivo de conexión:
   - Abre `config/database.php`
   - Verifica que los datos de conexión coincidan con tu configuración local

4. Accede al sistema:
   - Abre http://localhost/cielotico en tu navegador
   - Crea una cuenta o inicia sesión

## Estructura de Directorios

```
cielotico/
├── config/         # Configuración de la base de datos
├── css/           # Estilos CSS
├── html/          # Páginas PHP/HTML
├── img/           # Imágenes del sitio
├── js/            # Scripts JavaScript
├── php/           # Scripts PHP de procesamiento
├── sql/           # Archivos SQL y backups
└── templates/     # Plantillas reutilizables
```

## Mantenimiento

### Backup de Base de Datos
```bash
php php/sync_database.php
```

### Restaurar Base de Datos
```bash
php php/restore_database.php
```

## Contribución

1. Haz un fork del proyecto
2. Crea una rama para tu feature (`git checkout -b feature/NuevaCaracteristica`)
3. Haz commit de tus cambios (`git commit -m 'Agrega nueva característica'`)
4. Haz push a la rama (`git push origin feature/NuevaCaracteristica`)
5. Abre un Pull Request

## Seguridad

- Todas las contraseñas se almacenan hasheadas
- Protección contra SQL Injection usando PDO
- Validación de datos en formularios
- Control de acceso basado en roles
- Manejo seguro de sesiones

## Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## Contacto

Jeff Amador - [GitHub](https://github.com/WhizJeff) 