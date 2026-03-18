# Proyecto: Portafolio Profesional y Blog Personal (WordPress)

Este proyecto constituye mi identidad digital y técnica como estudiante de 2º de ASIR. Se trata de una plataforma web desarrollada para centralizar mi currículum, certificaciones oficiales y proyectos técnicos de la asignatura, garantizando un entorno de alto rendimiento y seguridad.

## 🚀 Infraestructura y Despliegue

La plataforma ha sido desplegada siguiendo estándares profesionales:

* **Contenerización:** Despliegue mediante **Docker y Docker Compose**, orquestando servicios aislados para la aplicación (WordPress) y la base de datos (MariaDB).
* **Persistencia:** Gestión de volúmenes de Docker para asegurar la integridad de la base de datos y el directorio `/wp-content`.

## 💻 Desarrollo y Base Tecnológica

* **Tema:** Uso de **Blocksy** con implementación de **Child Theme** para personalizaciones profundas.
* **Back-end:** Lógica inyectada en `functions.php` para minimizar el uso de plugins:
    * **Estética:** Paleta de colores Oxford Blue (#1e293b) y Terminal Green (#4ade80).
    * **Shortcodes:** Funciones personalizadas para fecha, hora y estado del sistema.
    * **Certificaciones:** Diseño "Bento Grid" para insignias de **Cisco** y **MoureDev Academy**.

## 🛡️ Seguridad (Hardening)

1. **Fuerza Bruta:** Control de accesos con bloqueo estricto tras 3 intentos.
2. **Ocultación:** Endpoint administrativo personalizado (404 en `/wp-admin`).
3. **Mantenimiento:** Copias de seguridad completas en formato `.wpress`.

---
*Documentación para el proyecto de Implantación de Aplicaciones Web (IAW) - Marzo 2026*
