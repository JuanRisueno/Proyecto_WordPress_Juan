<?php
/**
 * Encolar los estilos del tema padre e hijo.
 */
add_action( 'wp_enqueue_scripts', 'blocksy_child_enqueue_styles' );

function blocksy_child_enqueue_styles() {
    // 1. Carga el estilo del tema PADRE (Blocksy)
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    // 2. Carga TU estilo (el del tema HIJO)
    // Al añadir array('parent-style'), le decimos que espere a que cargue el padre primero
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array('parent-style'), wp_get_theme()->get('Version') );
}

/* --- REPARACIÓN DE VISIBILIDAD PARA JUAN --- */
add_action('admin_head', 'juan_fix_editor_visibility');

function juan_fix_editor_visibility() {
    echo '<style>
        /* Forzamos texto oscuro en el editor para no quedar ciegos */
        .editor-styles-wrapper p, 
        .editor-styles-wrapper h1, 
        .editor-styles-wrapper h2, 
        .editor-styles-wrapper h3, 
        .editor-styles-wrapper li,
        .editor-styles-wrapper span,
        .editor-styles-wrapper .wp-block-post-title,
        .block-editor-rich-text__editable {
            color: #1e293b !important;
            -webkit-text-fill-color: #1e293b !important;
        }
        /* Fondo blanco para el lienzo de edición */
        .editor-styles-wrapper { background-color: #ffffff !important; }
    </style>';
}

/**
 * FUERZA BRUTA: VISIBILIDAD PARA EL EDITOR DE BLOQUES (GUTENBERG)
 * Este hook es el único que garantiza que el CSS entre en el iframe del editor.
 */
add_action('enqueue_block_editor_assets', function() {
    wp_add_inline_style('wp-block-library', '
        /* 1. Forzamos texto oscuro y fondo blanco en el lienzo */
        .editor-styles-wrapper {
            background-color: #ffffff !important;
            color: #1e293b !important;
        }

        /* 2. Atacamos a todos los elementos de texto de forma agresiva */
        .editor-styles-wrapper :is(p, h1, h2, h3, h4, h5, h6, li, span, a) {
            color: #1e293b !important;
            -webkit-text-fill-color: #1e293b !important;
        }

        /* 3. Fix para el título principal y placeholders */
        .editor-post-title__block .editor-post-title__input,
        .wp-block-post-title,
        [data-rich-text-placeholder]::after {
            color: #1e293b !important;
            -webkit-text-fill-color: #1e293b !important;
        }

        /* 4. Si el cursor sigue siendo blanco, lo volvemos oscuro */
        .block-editor-writing-flow {
            caret-color: #1e293b !important;
        }
    ');
});

/* INYECCIÓN DE FUERZA BRUTA - v26.0 (FIX DE JERARQUÍA DOM) */
add_action('wp_head', function() {
    ?>
    <style id="juan-final-fix">
        /* 1. VARIABLES */
        :root {
            --theme-text-color: #1e293b !important;
            --theme-heading-color: #1e293b !important;
            --oxford: #1e293b;
            --blanco: #ffffff;
            --hover-gris: #94a3b8;
        }

        /* 2. CUERPO (Oxford sobre Crema) */
        body { background-color: #fdfbf7 !important; }
        
        /* Excluimos .has-background explícitamente para que no lo pise si la clase está en el propio título */
        body:not(.wp-admin) :is(h1, h2, h3, h4, h5, h6, .entry-title, .page-title, p, li):not(.has-background, .has-background *, .estilo-terminal, .estilo-terminal *, .ct-header *, .ct-footer *) {
            color: #1e293b !important;
            -webkit-text-fill-color: #1e293b !important;
        }

        /* 3. HEADER: Título, Descripción y Menú */
        header.ct-header { background-color: #1e293b !important; }
        header.ct-header .ct-site-title,
        header.ct-header .site-title,
        header.ct-header [data-id="logo"] {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            font-size: 1.5rem !important;
            font-weight: bold !important;
        }
        header.ct-header .ct-site-description {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            opacity: 1 !important;
            display: block !important;
            font-size: 0.9rem !important;
            margin-top: 5px !important;
        }
        header.ct-header .ct-main-menu a,
        header.ct-header .ct-main-menu .ct-menu-link,
        header.ct-header nav ul li a {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        header.ct-header a:hover,
        header.ct-header a:hover *,
        header.ct-header .ct-main-menu a:hover {
            color: var(--hover-gris) !important;
            -webkit-text-fill-color: var(--hover-gris) !important;
        }

        header.ct-header .current-menu-item > a,
        header.ct-header .current_page_item > a,
        header.ct-header .current-menu-ancestor > a {
            color: var(--hover-gris) !important;
            -webkit-text-fill-color: var(--hover-gris) !important;
            font-weight: bold !important;
        }

        /* 4. FOOTER */
        footer.ct-footer { background-color: #1e293b !important; }
        footer.ct-footer :is(p, span, a, .ct-footer-copyright) { color: #ffffff !important; }
        footer.ct-footer svg { fill: #ffffff !important; transition: all 0.3s ease !important; }
        footer.ct-footer a:hover svg { fill: var(--hover-gris) !important; transform: translateY(-3px) !important; }

        /* 5. BLOQUES OSCUROS */
        .has-background, .estilo-terminal {
            background-color: #334155 !important;
            border-radius: 15px !important;
            overflow: hidden !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
            /* Forzado directo de blanco al propio contenedor por si es un texto aislado */
            color: #ffffff !important; 
            -webkit-text-fill-color: #ffffff !important;
        }
        .has-background :is(h1, h2, h3, h4, p, li, a, span, strong),
        .estilo-terminal :is(h1, h2, h3, h4, p, li, a, span, strong) {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
        }

    /* 6. HOVER EXCLUSIVO PARA PROYECTOS, BARRA SUPERIOR Y FONDO WEB */

    /* Fondo global de la web: Forzamos el beige en todo el sitio */
    body {
        background-color: #f1f3f5 !important;
    }

    /* Panel superior de WordPress: fondo beige y texto oscuro */
    #wpadminbar {
        background-color: #f1f3f5 !important;
    }

    #wpadminbar * {
        color: #23282d !important;
    }

    /* Efectos para Proyectos */
    .estilo-terminal :is(h1, h2, h3, h4, p, li, a, span, strong) {
        transition: color 0.3s ease !important;
    }

    /* 7. AJUSTE DE IMÁGENES Y TEXTO EN PROYECTOS (ALINEACIÓN Y MÁRGENES) */
        
        /* Matamos los espacios fantasma debajo de las imágenes */
        .has-background figure, .estilo-terminal figure {
            margin: 0 !important;
            display: flex !important;
        }
        .has-background img, .estilo-terminal img {
            border-radius: 6px !important;
            margin: 15px !important;
            display: block !important; /* Elimina el espacio base del HTML */
            max-width: calc(100% - 30px) !important;
            object-fit: contain !important;
        }

        /* Centrado vertical absoluto para los contenedores (Columnas o Media) */
        .has-background .wp-block-columns, 
        .has-background .wp-block-media-text,
        .estilo-terminal .wp-block-columns,
        .estilo-terminal .wp-block-media-text {
            align-items: center !important;
        }

        /* Reseteo del margen inferior del texto para que el centrado sea matemático */
        .has-background :is(h1, h2, h3, h4, p):last-child,
        .estilo-terminal :is(h1, h2, h3, h4, p):last-child {
            margin-bottom: 0 !important;
        }

    /* 8. BOTONES DEL SISTEMA (Comentarios y Formularios) */
        #submit, .submit, button[type="submit"], input[type="submit"], .wp-block-button__link {
            background-color: #1e293b !important; /* Azul Oxford corporativo */
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            border: none !important;
            border-radius: 8px !important; /* Un redondeado intermedio y elegante */
            padding: 12px 24px !important;
            font-weight: bold !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
        }

        /* Efecto Hover para los botones (Solo cambia el texto) */
        #submit:hover, .submit:hover, button[type="submit"]:hover, input[type="submit"]:hover, .wp-block-button__link:hover {
            background-color: #1e293b !important; /* El fondo se queda fijo en azul Oxford */
            color: var(--hover-gris) !important; /* El texto cambia a azul clarito */
            -webkit-text-fill-color: var(--hover-gris) !important;
            transform: translateY(-2px) !important; /* Mantenemos el pequeño levante */
            box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
        }    

/* 10. FIX VOLVER ARRIBA (DESPEGUE DEL FOOTER) */
    
    /* Forzamos al contenedor y al botón a salir del flujo del footer */
    .ct-back-to-top, 
    [data-id="scroll-top"],
    .back-to-top {
        position: fixed !important;
        bottom: 60px !important; /* Lo subimos bastante para que no toque el footer */
        right: 40px !important;
        z-index: 99999 !important; /* Prioridad máxima sobre cualquier capa */
        
        /* Estética "Tech" */
        background-color: var(--oxford) !important;
        border: 2px solid var(--hover-gris) !important; /* Borde para que resalte en lo oscuro */
        width: 50px !important;
        height: 50px !important;
        border-radius: 50% !important;
        
        /* Sombras para dar profundidad */
        box-shadow: 0 8px 20px rgba(0,0,0,0.4) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    }

    /* Efecto al pasar el ratón (Hover) */
    .ct-back-to-top:hover, 
    [data-id="scroll-top"]:hover {
        background-color: #2d3748 !important;
        transform: translateY(-8px) scale(1.1) !important; /* Pequeño salto y aumento */
        border-color: #ffffff !important;
        box-shadow: 0 12px 25px rgba(0,0,0,0.5) !important;
    }

    /* Ocultamos cualquier residuo que intente quedarse dentro del footer */
    footer .ct-back-to-top-container {
        position: static !important;
        overflow: visible !important;
    }

/* 11. REINSTALACIÓN LIMPIA: FORMULARIO TÉCNICO ASIR (COLORES CORPORATIVOS) */

/* 1. Contenedor principal: Gris Oxford de los proyectos */
.wpforms-container {
    background-color: #334155 !important;
    padding: 40px !important;
    border-radius: 15px !important;
    border: 1px solid #94a3b8 !important; /* Borde corporativo */
    max-width: 900px !important;
    width: 98% !important;
    margin: 40px auto !important;
}

/* 2. Forzar Nombre y Apellidos en dos columnas */
.wpforms-field-name .wpforms-field-row {
    display: flex !important;
    flex-direction: row !important; 
    gap: 20px !important;
}

.wpforms-field-name .wpforms-field-row-block {
    flex: 1 !important;
    width: 50% !important;
}

/* 3. Forzar Email y campos de texto al 100% */
.wpforms-field-container .wpforms-field {
    width: 100% !important;
    clear: both !important;
}

.wpforms-field input[type="text"],
.wpforms-field input[type="email"],
.wpforms-field textarea,
.wpforms-field select {
    background-color: #1e293b !important; /* Fondo consola profunda */
    border: 1px solid #94a3b8 !important; /* Borde visible y simétrico */
    color: #ffffff !important;
    width: 100% !important;
    padding: 12px !important;
    border-radius: 8px !important;
    box-sizing: border-box !important;
}

/* 4. Visibilidad total de etiquetas (Blanco y Gris claro) */
.wpforms-field-label {
    color: #ffffff !important; 
    font-family: 'Courier New', Courier, monospace !important;
}

.wpforms-field-sublabel {
    color: #cbd5e1 !important; /* Gris claro para no saturar */
    font-family: 'Courier New', Courier, monospace !important;
}

.wpforms-field-label-inline {
    font-family: 'Courier New', Courier, monospace !important;
    font-size: 0.9rem !important;
    margin-left: 8px !important;
}

/* 5. Radio buttons y Checkboxes (Limpios) */
.wpforms-field-radio ul, 
.wpforms-field-checkbox ul {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 15px 30px !important;
    padding: 10px 0 !important;
    list-style: none !important;
}

.wpforms-field-radio li, 
.wpforms-field-checkbox li {
    flex: 0 0 45% !important; 
    display: flex !important;
    align-items: center !important;
}

.wpforms-field input[type="radio"], 
.wpforms-field input[type="checkbox"] {
    width: 18px !important;
    height: 18px !important;
    margin: 0 !important;
    cursor: pointer !important;
    accent-color: #94a3b8 !important; /* Check en color corporativo */
}

/* 6. Botón de envío: Terminal interactiva */
.wpforms-submit-container {
    text-align: right !important;
    margin-top: 20px !important;
}

.wpforms-submit {
    background-color: #1e293b !important;
    color: #ffffff !important;
    border: 2px solid #94a3b8 !important;
    padding: 12px 60px !important;
    font-weight: bold !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important; /* Suavidad al pasar el ratón */
}

/* Efecto hover del botón */
.wpforms-submit:hover {
    background-color: #94a3b8 !important;
    color: #1e293b !important;
}

/* 7. Fix para móvil */
@media (max-width: 600px) {
    .wpforms-field-name .wpforms-field-row {
        flex-direction: column !important;
    }
    .wpforms-field-name .wpforms-field-row-block,
    .wpforms-field-radio li, 
    .wpforms-field-checkbox li {
        width: 100% !important;
        flex: 0 0 100% !important;
    }
}
    
/* --- FIX EXCLUSIVO DE COLOR PARA RADIO Y CHECKBOX --- */
.wpforms-container .wpforms-form .wpforms-field-radio .wpforms-field-label-inline,
.wpforms-container .wpforms-form .wpforms-field-checkbox .wpforms-field-label-inline {
    color: #ffffff !important;
    opacity: 1 !important;
    -webkit-text-fill-color: #ffffff !important;
}

/* 12. DISEÑO LIMPIO PARA EL MENÚ HAMBURGUESA (BLOCKSY) */

/* 1. La caja del botón: tamaño perfecto y espaciado */
.ct-header-trigger,
[data-id="mobile-menu-toggle"] {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 45px !important; /* Ancho táctil ideal */
    height: 45px !important; /* Alto táctil ideal */
    border: 1px solid #94a3b8 !important; /* Borde gris corporativo */
    border-radius: 8px !important;
    background-color: transparent !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
}

/* 2. El icono (las 3 rayas): color puro sin deformar */
.ct-header-trigger svg,
[data-id="mobile-menu-toggle"] svg {
    width: 24px !important;
    height: 24px !important;
}

/* 3. Las líneas internas del vector */
.ct-header-trigger svg rect,
.ct-header-trigger svg path,
[data-id="mobile-menu-toggle"] * {
    fill: #ffffff !important; /* Relleno blanco */
    stroke: none !important; /* MATAMOS EL STROKE PARA QUE NO ENGORDE */
}

/* 4. Efecto Hover (al pasar el ratón) */
.ct-header-trigger:hover {
    background-color: #1e293b !important; /* Fondo consola */
    border-color: #ffffff !important;
}

.ct-header-trigger:hover svg rect,
.ct-header-trigger:hover svg path {
    fill: #94a3b8 !important; /* Líneas en gris corporativo */
}

/* 13. RESPONSIVE: AJUSTE DE TARJETAS DE PROYECTOS EN MÓVIL */

@media (max-width: 768px) {
    /* 1. Centramos todo el contenido de la tarjeta */
    .entries-wrap article, 
    .wp-block-post {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        padding: 20px 15px !important;
    }

    /* 2. Hacemos la imagen más pequeña (60% del ancho) y la centramos */
    .entries-wrap article .ct-image-container,
    .entries-wrap article img,
    .wp-block-post-featured-image img,
    .wp-block-post figure {
        max-width: 60% !important; /* Reduce el tamaño */
        height: auto !important;
        margin: 0 auto 15px auto !important; /* Centrado horizontal */
        border-radius: 8px !important;
    }

    /* 3. Reducimos el tamaño de la letra del título para que no ocupe tanto */
    .entries-wrap article .entry-title,
    .wp-block-post-title,
    .wp-block-post-title a {
        font-size: 1.3rem !important; /* Letra más comedida */
        text-align: center !important;
        line-height: 1.4 !important;
        margin-bottom: 10px !important;
    }
}

/* 14. TARJETAS DE CERTIFICACIÓN (BENTO STYLE) */
.tarjeta-cert {
    background-color: #334155 !important; /* Gris Oxford de tus proyectos */
    border: 1px solid #94a3b8 !important; /* Borde sutil corporativo */
    border-radius: 15px !important;
    padding: 30px !important;
    text-align: center !important;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
}

/* Efecto Hover: Elevación y resplandor verde 'System OK' */
.tarjeta-cert:hover {
    transform: translateY(-12px) !important;
    border-color: #4ade80 !important; /* Verde del shortcode [estado_sys] */
    box-shadow: 0 15px 35px rgba(74, 222, 128, 0.15) !important;
    background-color: #1e293b !important; /* Oscurecimiento sutil */
}

/* Ajuste de los logos: Uniformidad total */
.tarjeta-cert img {
    width: 220px !important;   /* Subimos de 100px a 220px */
    height: 180px !important;  /* Altura proporcional para que respiren */
    object-fit: contain !important; /* Mantiene la proporción sin deformar */
    margin-bottom: 10px !important; /* Reducimos un poco el margen inferior */
    filter: drop-shadow(0 6px 12px rgba(0,0,0,0.4)) !important; /* Sombra más profunda */
    display: block !important;
    transition: transform 0.3s ease !important;
}

/* Efecto extra: El logo crece un poquito más al pasar el ratón */
.tarjeta-cert:hover img {
    transform: scale(1.1) !important;
}

.tarjeta-cert h3 {
    font-family: 'Courier New', Courier, monospace !important;
    color: #ffffff !important;
    font-size: 1.1rem !important;
    margin-top: 0 !important;
    margin-bottom: 10px !important;
}

.tarjeta-cert p {
    font-size: 0.85rem !important;
    color: #cbd5e1 !important; /* Gris claro para lectura */
    line-height: 1.4 !important;
    margin-bottom: 0 !important;
}

    </style>
    <?php
}, 999);

// Forzar soporte de imágenes destacadas
add_action('init', function() { add_theme_support('post-thumbnails'); }, 999);
add_action('after_setup_theme', function() { add_theme_support('post-thumbnails'); }, 999);

// --- SHORTCODES ---

// 1. Shortcode para la fecha actual [fecha_actual]
function generar_fecha_actual() {
    $fecha = wp_date('d/m/Y');
    return '<span style="color: #94a3b8; font-family: \'Courier New\', Courier, monospace;">' . $fecha . '</span>'; 
}
add_shortcode('fecha_actual', 'generar_fecha_actual');

// 2. Shortcode para la hora actual [hora_actual]
function generar_hora_actual() {
    $hora = wp_date('H:i');
    return '<span style="color: #ffffff; font-family: \'Courier New\', Courier, monospace; font-weight: bold;">' . $hora . '</span>'; 
}
// Asegúrate de no duplicar el add_shortcode, deja solo este:
add_shortcode('hora_actual', 'generar_hora_actual');

// 3. Shortcode para el año actual, para añadiro al Copyright [anno_actual]
function generar_anno_actual() {
    $anno = wp_date('Y');
    return '<span style="color: #94a3b8; font-family: \'Courier New\', Courier, monospace;">' . $anno . '</span>';
}
add_shortcode('anno_actual', 'generar_anno_actual');

// 4. Shortcode de estado del servidor [estado_sys]
function indicador_estado_sistema() {
    // Usamos color verde para simular que el servicio está levantado
    return '<span style="color: #4ade80; font-family: \'Courier New\', Courier, monospace; font-weight: bold;">● All Systems Operational</span>';
}
add_shortcode('estado_sys', 'indicador_estado_sistema');