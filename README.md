# Sistema Integrado de Gestión de Inventario y Ventas - TecnoStore 🚀
**Asignatura:** Laboratorio de Bases de Datos (ETN-1000)  
**Institución:** Universidad Mayor de San Andrés (UMSA)  
**Gestión:** 2026  
**Estudiante:** Diego  

---

## 📝 Descripción del Proyecto
Este proyecto representa la consolidación sistémica de los hitos avanzados a lo largo del semestre académico. Consiste en una aplicación web transaccional multi-rol estructurada bajo una arquitectura monolítica (PHP/MySQL) que integra el diseño estático, modelado relacional e interconexión con APIs externas en la nube.

El sistema implementa una separación lógica de entornos:
*   **Módulo de Clientes:** Permite el registro de usuarios en la base de datos relacional, obtención de credenciales únicas (ID de Cliente), navegación por un catálogo dinámico y la simulación transaccional de compras con afectación directa en las existencias de inventario.
*   **Panel de Administración:** Panel restringido mediante autenticación criptográfica local para el control de inventarios y el abastecimiento del catálogo web (`producto`).

---

## 🛠️ Tecnologías Utilizadas
*   **Diseño Frontend:** HTML5, CSS3 (Estructuración mediante Flexbox y CSS Grid), fuentes tipográficas integradas mediante Google Fonts (Roboto, Open Sans).
*   **Backend & Servidor:** PHP 8 (Arquitectura orientada a objetos empleando PDO para el control seguro de transacciones y prevención de Inyección SQL).
*   **Motor de Base de Datos:** MySQL (Modelado inicial en Workbench y migración hacia phpMyAdmin/MariaDB).
*   **Consumo de APIs:** Conexión asíncrona mediante Fetch API en JavaScript hacia *ExchangeRate-API* para la cotización de divisas en tiempo real (BOB/USD).
*   **Control de Versiones:** Git & GitHub.
*   **Entorno de Despliegue:** Producción remota en InfinityFree.

---

## 🗄️ Arquitectura y Diseño de la Base de Datos
La persistencia de datos se compone de 4 entidades lógicas fuertemente relacionadas para resguardar la integridad referencial:
1.  **`cliente`**: Almacena los metadatos de los compradores (ID autoincremental, nombre, email, dirección y marca de tiempo).
2.  **`producto`**: Catálogo maestro de existencias con restricciones de stock.
3.  **`pedido`**: Cabecera transaccional vinculada de forma unívoca a un cliente.
4.  **`detalle_pedido`**: Entidad de quiebre relacional de muchos a muchos que registra los ítems comprados, cantidades y el costo histórico unitario.

---

## 🚀 Historial de Evolución de Laboratorios
*   **Laboratorio 4 & 5:** Maquetación responsiva estructural, identidad corporativa y control de estilos unificados.
*   **Laboratorio 6 & 7:** DDL (Estructura de tablas con restricciones `FOREIGN KEY`) y DML (Poblado de datos iniciales en el motor relacional).
*   **Laboratorio 8 & 9:** Formulario dinámico de inyección de datos PHP-PDO y conversión del catálogo estático a un catálogo dinámico iterado.
*   **Laboratorio 10:** Consumo de servicios de terceros (API de tipo de cambio en vivo).
*   **Laboratorio 11 (Final):** Unificación de la arquitectura multi-rol, control transaccional con consultas preparadas, descuento automático de stock, control de versiones al día y despliegue del sistema en la web.