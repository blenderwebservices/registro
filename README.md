# Registro - Expo Mecánico Automotriz

## Objetivo
El objetivo de este formulario es capturar los datos de registro (Pre-registro web y versiones in situ/Tablet) para los asistentes a la **Expo Mecánico Automotriz Internacional**. El sistema almacena la información personal, de contacto, institución/empresa, origen y giro especializado en una base de datos MySQL, enviando adicionalmente un correo electrónico de confirmación generado mediante PHPMailer que contiene un Código QR de ingreso.

## Arquitectura y Tecnologías
La arquitectura del pequeño sistema de registro está dividida tradicionalmente en:
- **Frontend:** Formularios HTML y validación/peticiones AJAX en JavaScript (jQuery) para consumo de API y base de datos `(buscar_registro.php)`.
- **Backend:** Scripts de PHP `(guardar_registro.php, guardar_registro2.php, guardar_tablet.php, buscar_ediciones.php)` que validan y persisten datos en MySQL y manejan envíos por SMTP a través de `PHPMailer`.
- **Base de Datos:** Múltiples entornos MySQL administrados configurados en un único archivo modular `(db_config.php)`.
- **Dependencias adyacentes:** `phpqrcode` para generación y almacenamiento de imágenes PNG.

### Tecnologías Iniciales Originales (< 2024)
- **Frontend CSS:** Bootstrap 3.x/4.x mixto (`bootstrap.min.css`), plantillas genéricas `util.css` y `main.css`.
- **Frontend JS:** jQuery `3.2.1.min.js`, Select2, daterangepicker y noUiSlider. Validaciones por lógica condicional bloqueante (ocultaba el botón enviar `boton_completar.png`).
- **Backend PHP:** PHP procedural para inserción MySQL usando extensiones `mysqli_query` básicas. (Versiones de PHP 5.6 - 7.4 según directivas obsoletas).
- Pobre estructuración de interfaces (múltiples estilos CSS de Bootstrap apilados).
- Repetición excesiva de credenciales de Base de Datos interconectadas *Hardcoded*.

### Tecnologías Utilizadas para mejorar la UX/UI (Refactor 2026)
Con la iteración para **Expo Mecánico Automotriz León 2026**, se propusieron importantes sugerencias de usabilidad (UX):
- **Sugerencia 1:** Evitar la frustración del usuario al no saber *por qué* no puede enviar un formulario (ocultamiento de botones). 
- **Sugerencia 2:** Mejorar la jerarquización de los datos pidiéndolos en bloques lógicos (Personal, Contacto, Ubicación y Segmentación/Giro).
- **Sugerencia 3:** Aspecto estéticamente premium que de confianza al asistente durante el registro.

**Para lograrlo se integró:**
- **Tailwind CSS (Vía CDN v3):** En sustitución del código base engorroso de Bootstrap. Se aplicó *Glassmorphism* (tarjetas translucidas), animaciones de bordes, Sombras de Elevación, gradientes interactivos de marca (Rojo/Oscuro), adaptabilidad total para Smartphones y Tablets (Mobile First) e iconos *Font Awesome 6*.
- **Toastify JS (Vía CDN):** Usada para reemplazar las ineficientes alertas nativas (`alert()`) por notificaciones contextuales interactivas y coloridas ("Roasts") que advierten en tiempo real sobre errores de validación de correo, o de campos vacíos.
- **Tipografía Moderna:** Google Fonts (*Inter* para inputs; *Outfit* para Títulos). 

## Estructura Consolidada de Base de Datos
- Durante el refactor de **Marzo de 2026** se encapsuló la conexión a 3 clústeres diferentes de bases de datos de `ionos`, centralizando usuarios, contraseñas y puertos en el nuevo archivo `php/db_config.php` (Incluyendo modo localhost en entorno dev).

## Historial de Fechas Clave
- *Orígenes del Código Base:* Aparentemente estructurado desde finales de **2019 / Princpios de 2021** *(Basado en comentarios de versiones "edi21", configuradores de librerías ext/ y "PHPMailer2021")*.
- *Actualizaciones Generales de Backend PhpMailer y MySQLi:* **Entre 2024 y 2025** para Pachuca 2025.
- *Remodelación Front-end/UX, Fix de codificación UTF-8 Multibyte (strtr)* y *Extracción DB (Centralización)*: **14-15 de Marzo, 2026**.
