# 🏟️ Proyecto 2 – Sistema de Reservación de Canchas Deportivas “Gambeta”

Integrantes:
- Yahir Ariel Nieto Amaya (YANA021 / YANA01)
- Germán Daniel Hernández Pinto (Geer27)
- Diego Alejandro Flores Montesinos (XxAlexX003)
- Jasson Armando Gómez Guevara (jason7337)

> 💡 Nota: los comandos se muestran en bloques `bash` para que puedas copiar y pegar fácilmente:
> ```bash
> ./vendor/bin/sail up -d
> ```

Aplicación web desarrollada con **Laravel 12**, **Livewire v3**, **TailwindCSS**, **MySQL** y **Laravel Sail (Docker)**.

El sistema permite gestionar canchas, reservas, pagos, historial, clientes frecuentes y disponibilidad en tiempo real.

---

# 🚀 Instalación y configuración con Laravel Sail (Docker)

A continuación se detallan los pasos necesarios para instalar, configurar y ejecutar el proyecto en un entorno Linux/WSL utilizando Docker y Laravel Sail.

> ⚠️ IMPORTANTE:  
> Todos los comandos deben ejecutarse dentro de **Ubuntu/WSL**.  
> No uses CMD ni PowerShell para trabajar con Sail.

---

## 🟦 1. Abrir Ubuntu / WSL
Abre tu terminal de Ubuntu para comenzar la instalación.

---

## 🟦 2. Crear una carpeta para proyectos (opcional)

```bash
cd ~
mkdir proyectos
cd proyectos
```

---

## 🟦 3. Clonar el repositorio

```bash
git clone https://github.com/YANA021/proyecto2-gambeta.git
cd proyecto2-gambeta
```

---

## 🟦 4. Crear el archivo `.env`

Laravel requiere un archivo `.env` para configuraciones del entorno.

```bash
cp .env.example .env
```

Editar los valores de conexión para Docker/Sail:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=gambeta
DB_USERNAME=sail
DB_PASSWORD=123456
```

> ⚠️ Nota: No subas tu archivo `.env` real a GitHub.

---

## 🟦 5. Instalar dependencias de PHP con Composer dentro de Sail

```bash
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php83-composer:latest \
  composer install --ignore-platform-reqs
```

Esto instalará la carpeta `vendor`.

---

## 🟦 6. Dar permisos a los binarios de Sail (solo la primera vez)

```bash
sudo chown -R $USER:$USER .
chmod +x ./vendor/bin/sail
chmod -R +x ./vendor/laravel/sail/bin
```

---

## 🟦 7. Levantar Sail (Docker)

```bash
./vendor/bin/sail up -d
```

Si aparece error de permisos:

```bash
sudo usermod -aG docker $USER
exit  # cierra terminal y vuelve a entrar
```

---

## 🟦 8. Generar clave de Laravel

```bash
./vendor/bin/sail artisan key:generate
```

---

## 🟦 9. Ejecutar migraciones

```bash
./vendor/bin/sail artisan migrate
```

---

## 🟦 10. Instalar dependencias de JavaScript

```bash
./vendor/bin/sail npm install
```

---

## 🟦 11. Ejecutar Vite (modo desarrollo)

En otra terminal:

```bash
./vendor/bin/sail npm run dev
```

Esto habilita:

* Tailwind en tiempo real
* Livewire recargando automáticamente
* Compilación instantánea de assets

Mantén esta terminal abierta durante el desarrollo.

---

## 🟦 12. Abrir el proyecto en el navegador

```
http://localhost
http://localhost:8082/   # phpMyAdmin si está configurado
```

---

# 📦 Tecnologías principales

* **Laravel 12**
* **Laravel Sail (Docker)**
* **Livewire v3**
* **TailwindCSS**
* **MySQL 8**
* **Vite**
* **Alpine.js**
* **Docker / Docker Compose**

---

# 👥 Roles del sistema

## 🟩 Administrador

* Acceso total al sistema
* Gestión completa de canchas
* Gestión de reservas
* Bloqueo de horarios
* Gestión de precios
* Gestión de usuarios
* Ver reportes y estadísticas
* Historial de reservas por cancha

## 🟦 Empleado de recepción

* Crear reservas
* Ver calendario de disponibilidad
* Cambiar estado de reservas (pendiente, confirmada, cancelada, finalizada)
* Registrar pagos y adelantos
* Ver listado de clientes
* Consultar historial de clientes frecuentes
* NO puede eliminar canchas
* NO puede modificar precios
* NO tiene acceso al panel administrativo

---

# 🧩 Funcionalidades principales

* Registro y administración de canchas (nombre, tipo, precio, imagen)
* Calendario de reservas con disponibilidad en tiempo real
* Validación para evitar choques de horario
* Reservación de canchas con clientes y cálculo automático del total
* Control de estados de reserva
* Módulo de pagos con validación de adelantos y saldo restante
* Generación de comprobantes PDF
* Registro de clientes frecuentes
* Panel de administración completo
* Roles con permisos diferenciados
* Interfaz moderna, responsiva y dinámica

---

# 📝 Licencia

Proyecto desarrollado para fines académicos en la materia **Técnicas de Programación para Internet (TPI)**.
Su uso es únicamente educativo; queda prohibido su uso comercial.
