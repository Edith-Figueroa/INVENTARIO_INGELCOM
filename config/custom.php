<?php

// Configuración Personalizada

return [
  'custom' => [
    'myLayout' => 'vertical', // Opciones[Cadena]: vertical(predeterminado), horizontal  EL DISEÑO HORIZONTAL NO FUNCIONARÁ CON EL TEMA SEMI-OSCURECIDO
    'myTheme' => 'theme-default', // Opciones[Cadena]: theme-default(predeterminado), theme-bordered, theme-semi-dark  EL TEMA SEMI-OSCURECIDO NO FUNCIONARÁ CON EL DISEÑO HORIZONTAL
    'myStyle' => 'light', // Opciones[Cadena]: light(predeterminado), dark
    'myRTLSupport' => true, // opciones[Booleano]: true(predeterminado), false // Proporcionar soporte RTL o no
    'myRTLMode' => false, // opciones[Booleano]: false(predeterminado), true // Establecer el diseño en modo RTL (myRTLSupport debe ser true para el modo rtl)
    'hasCustomizer' => true, // opciones[Booleano]: true(predeterminado), false // Mostrar el personalizador o no. ESTO ELIMINARÁ EL ARCHIVO JS INCLUIDO. POR LO TANTO, EL ALMACENAMIENTO LOCAL NO FUNCIONARÁ
    'displayCustomizer' => false, // opciones[Booleano]: true(predeterminado), false // Mostrar la interfaz de usuario del personalizador o no. ESTO NO ELIMINARÁ EL ARCHIVO JS INCLUIDO. POR LO TANTO, EL ALMACENAMIENTO LOCAL FUNCIONARÁ
    'menuFixed' => true, // opciones[Booleano]: true(predeterminado), false // Diseño (menú) fijo
    'menuCollapsed' => false, // opciones[Booleano]: false(predeterminado), true // Mostrar el menú colapsado, solo para el diseño vertical
    'navbarFixed' => false, // opciones[Booleano]: false(predeterminado), true // Barra de navegación fija
    'footerFixed' => false, // opciones[Booleano]: false(predeterminado), true // Pie de página fijo
    'showDropdownOnHover' => true, // true, false (solo para el diseño horizontal)
    'customizerControls' => [
      'rtl',
      'style',
      'layoutType',
      'showDropdownOnHover',
      'layoutNavbarFixed',
      'layoutFooterFixed',
      'themes',
    ], // Mostrar/ocultar opciones del personalizador
  ],
];