# Proyecto Web WordPress: Portafolio Profesional y Blog Personal

Este proyecto constituye mi identidad digital y técnica como futuro Administrador de Sistemas Informáticos en Red (ASIR). Se trata de una plataforma web personal desarrollada para centralizar mi currículum, certificaciones oficiales y proyectos técnicos, garantizando un entorno de alto rendimiento, escalabilidad y máxima seguridad.

## 🚀 Infraestructura y Despliegue

La plataforma ha sido desplegada siguiendo estándares profesionales de administración de sistemas:

* **Host Privado:** Estación de trabajo bajo **CachyOS** (Kernel Linux con optimizaciones de rendimiento y programación de tareas).
* **Hardware de Desarrollo:** Ryzen 7 5800x3D | AMD RX 6800 | 32 GB RAM DDR4.
* **Contenerización:** Despliegue mediante **Docker y Docker Compose**, orquestando servicios aislados para la aplicación (WordPress) y la persistencia de datos (MariaDB/MySQL).
* **Persistencia:** Gestión de volúmenes de Docker para asegurar la integridad de la base de datos y el directorio de medios (`wp-content`).

## 💻 Desarrollo y Base Tecnológica

Se ha realizado un trabajo de ingeniería sobre la base del CMS:

* **Tema Base:** Se ha seleccionado **Blocksy** por su rendimiento ligero y estructura moderna.
* **Implementación de Child Theme:** Para garantizar la integridad del sistema ante actualizaciones, toda la lógica se ha desarrollado sobre un tema hijo.
* **Personalización (Back-end):** Para minimizar el uso de plugins ("Bloatware"), la lógica y el diseño se han inyectado directamente en el archivo `functions.php`:
    * **Estética Corporativa:** Diseño basado en una paleta técnica de colores (**Oxford Blue** `#1e293b` y **Terminal Green** `#4ade80`).
    * **Funciones Personalizadas (Shortcodes):** `[fecha_actual]`, `[hora_actual]`, `[estado_sys]` y `[anno_actual]`.
    * **Sección de Certificaciones:** Diseño tipo "Bento Grid" para los títulos de **Cisco (CCST Cybersecurity & Networking)** y **MoureDev Academy (Backend Python)**, con optimización de imagen mediante `object-fit: contain`.

## 🛡️ Hardening y Seguridad Activa

Como proyecto de ASIR, la seguridad se ha implementado bajo el principio de **Defensa en Profundidad**:

1.  **Mitigación de Fuerza Bruta:** Configuración de políticas de acceso mediante **Limit Login Attempts Reloaded**. Bloqueo estricto tras **3 intentos fallidos** por un periodo de **24 horas**.
2.  **Seguridad por Oscuridad:** Ofuscación del punto de entrada administrativo mediante **WPS Hide Login**, desactivando el endpoint estándar `/wp-admin` (Error 404).
3.  **Integridad de Sesión:** Auditoría de cookies y control de sesiones activas.

## 🛠 Mantenimiento y Recuperación

* **Backups:** Sistema de copias de seguridad completas en formato `.wpress` mediante **All-in-One WP Migration**.
* **Optimización:** Diseño **Responsive** adaptado mediante `@media queries` personalizadas para garantizar la usabilidad en dispositivos móviles.
* **Control de Errores:** Gestión directa de archivos de configuración crítica del sistema y del CMS.

## 👥 Equipo y Colaboraciones
* **Líder de Proyecto:** Juan (Estudiante de 2º de ASIR).
* **Colaboradores Técnicos (PFG):** Jorge y Alfonso.

---
